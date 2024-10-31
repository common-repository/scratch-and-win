<?php
namespace SOSIDEE_SAW\SRC;
defined( 'SOSIDEE_SAW' ) or die( 'you were not supposed to be here' );

use \SOSIDEE_SAW\SOS\WP\DATA as DATA;

class Database
{
    private $native;

    public function __construct() {

        $this->native = new DATA\WpDatabase('sos_saw_');

        // TABLE GAMES
        $games = $this->native->addTable("games");
        $games->addID("game_id");
        $games->addTinyInteger("status");
        $games->addVarChar("description", 255);
        $games->addInteger("ticket_tot");

        $games->addVarChar("loss_url", 255);
        $games->addVarChar("loss_text", 512);
        $games->addVarChar("end_text", 512);
        $games->addVarChar("end_url", 255);
        $games->addBoolean("end_disabled")->setDefaultValue(false);

        $games->addInteger("image_cover");
        $games->addInteger("image_loss");
        $games->addInteger("image_coin");
        $games->addBoolean("image_size_auto");
        $games->addVarChar("image_css_class", 64);

        $games->addInteger("scratch_percentage")->setDefaultValue(90);

        $games->addInteger("user_max_tot");
        $games->addVarChar("user_max_text", 512);
        $games->addVarChar("user_max_url", 255);

        $games->addInteger("user_unit_max");
        $games->addTinyInteger("user_unit_type");
        $games->addVarChar("user_unit_text", 512);
        $games->addVarChar("user_unit_url", 255);

        $games->addBoolean("user_email_disabled")->setDefaultValue(false);
        $games->addBoolean("user_anonymous")->setDefaultValue(false);

        $games->addTinyInteger("timeout_redirect");

        $games->addBoolean("ticket_key_show")->setDefaultValue(false);
        $games->addBoolean("random_qs_url")->setDefaultValue(false);

        $games->addDateTime("creation")->setDefaultValueAsCurrentDateTime();
        $games->addBoolean("deleted")->setDefaultValue(false);

        // TABLE PRIZES
        $prizes = $this->native->addTable("prizes");
        $prizes->addID("prize_id");
        $prizes->addInteger("game_id");
        $prizes->addVarChar("description", 255);

        $prizes->addInteger("win_ticket"); // number of winning tickets
        $prizes->addInteger("win_image");
        $prizes->addVarChar("win_text", 512);
        $prizes->addVarChar("win_url", 255);
        $prizes->addInteger("win_user_max");

        $prizes->addVarChar("email_subject", 255);
        $prizes->addVarChar("email_body", 1024);

        $prizes->addDateTime("creation")->setDefaultValueAsCurrentDateTime();
        $prizes->addBoolean("cancelled")->setDefaultValue(false);
        $prizes->addBoolean("deleted")->setDefaultValue(false);

        // TABLE TICKETS
        $tickets = $this->native->addTable("tickets");
        $tickets->addID("ticket_id");
        $tickets->addInteger("prize_id"); // 0 => LOSS // !=0 => WIN
        $tickets->addInteger("game_id");
        $tickets->addInteger("user_id");
        $tickets->addVarChar("user_email", 255);
        $tickets->addDateTime("creation")->setDefaultValueAsCurrentDateTime();
        $tickets->addBoolean("cancelled")->setDefaultValue(false);
        $tickets->addBoolean("deleted")->setDefaultValue(false);

        $this->native->create();
    }

    public function getTable( $name ) {
        return $this->native->getTable($name);
    }

    public function loadGames( $filters = [], $orders = [] ) {
        $table = $this->native->games;
        $where = [];
        if ( key_exists('id', $filters) && $filters['id'] > 0  ) {
            $where[$table->game_id->name] = intval( $filters['id'] );
        }

        if ( key_exists('status', $filters) && $filters['status'] != GameStatus::NONE  ) {
            $where[$table->status->name] = intval( $filters['status'] );
        }


        if ( !key_exists('deleted', $filters) ) {
            $where[$table->deleted->name] = false;
        } else {
            $where[$table->deleted->name] = boolval( $filters['deleted'] );
        }

        $others = [ 'status[<>]' ];
        for ( $n=0; $n<count($others); $n++ ) {
            $key = $others[$n];
            if ( key_exists($key, $filters)  ) {
                $where[$key] = $filters[$key];
            }
        }

        return $table->select( $where, $orders );
    }

    public function loadGame( $id ) {
        $table = $this->native->games;
        $field = $table->game_id->name;

        $results = $table->select( [
            $field => $id
        ] );

        if ( is_array($results) ) {
            if ( count($results) == 1 ) {
                return $results[0];
            } else {
                sosidee_log("Database.loadGame($id) :: WpTable.select() returned a wrong array length: " . count($results) . " (requested: 1)" );
                return false;
            }
        } else {
            return false;
        }
    }

    public function saveGame( $data, $id = 0 ) {
        $table = $this->native->games;
        if ( $id > 0 ) {
            return $table->update( $data, [ 'game_id' => $id ] );
        } else {
            return $table->insert( $data );
        }
    }

    public function deleteGame( $id ) {
        $ret = false;
        if ( $this->deletePrizesByGame( $id ) ) {
            $table = $this->native->games;
            $ret = $table->update( [ 'deleted' => true ], [ 'game_id' => $id ] );
        }
        return $ret;
    }

    public function loadPrizes( $game_id, $only_enabled = false, $orders = ['creation' => 'DESC'] ) {
        $table = $this->native->prizes;
        $where = [
              $table->game_id->name => $game_id
            , $table->deleted->name => false
        ];

        if ( $only_enabled ) {
            $where[$table->cancelled->name] = false;
        }

        return $table->select( $where, $orders );
    }

    public function loadPrize( $id ) {
        $table = $this->native->prizes;
        $field = $table->prize_id->name;

        $results = $table->select( [
            $field => $id
        ] );

        if ( is_array($results) ) {
            if ( count($results) == 1 ) {
                return $results[0];
            } else {
                sosidee_log("Database.loadPrize($id) :: WpTable.select() returned a wrong array length: " . count($results) . " (requested: 1)" );
                return false;
            }
        } else {
            return false;
        }
    }

    public function savePrize( $data, $id = 0 ) {
        $table = $this->native->prizes;
        if ( $id > 0 ) {
            return $table->update( $data, [ 'prize_id' => $id ] );
        } else {
            return $table->insert( $data );
        }
    }

    public function deletePrize( $id ) {
        $ret = false;
        if ( $this->deleteTicketsByPrize( $id ) ) {
            $table = $this->native->prizes;
            $ret = $table->update( [ 'deleted' => true ], [ 'prize_id' => $id ] );
        }
        return $ret;
    }
    public function deletePrizesByGame( $game_id ) {
        $ret = false;
        if ( $this->deleteTicketsByGame( $game_id ) ) {
            $table = $this->native->prizes;
            $ret = $table->update( [ 'deleted' => true ], [ 'game_id' => $game_id ] );
        }
        return $ret;
    }

    private function getTicketRecords($results) {
       $ret = false;
        if ( is_array($results) ) {
            for ( $n=0; $n<count($results); $n++ ) {
                $columns = &$results[$n];
                foreach ( $columns as $name => $value ) {
                    $columns->{$name} = intval($value);
                }
                unset($columns);
            }
            $ret = $results;
        } else {
            sosidee_log("Database.getTicketRecords(\$results) \$results in not an array.");
        }
        return $ret;
    }

    public function countTickets( $game_id = 0, $prize_id = 0 ) {

        $table = $this->native->tickets;

        $values = [];
        $groups = [];

        $sql = "SELECT COUNT({$table->ticket_id->name}) AS used";
        $where = "{$table->deleted->name}=0 AND {$table->cancelled->name}=0";
        if ( $game_id > 0 ) {
            $where .= " AND {$table->game_id->name}=%d";
            $values[] = $game_id;
        } else {
            $sql .= ",{$table->game_id->name}";
            $groups[] = $table->game_id->name;
        }
        if ( $prize_id > 0 ) {
            $where .= " AND {$table->prize_id->name}=%d";
            $values[] = $prize_id;
        } else {
            $sql .= ",{$table->prize_id->name}";
            $groups[] = $table->prize_id->name;
        }
        $sql .= " FROM {$table->name} WHERE $where";
        if ( count($groups) > 0) {
            $sql .= " GROUP BY " . implode(',', $groups);
        }

        $results = $this->native->select( $sql, $values );

        return $this->getTicketRecords( $results );
    }

    public function countUserTickets( $user_id, $game_id, $prize_id = 0 ) {

        $table = $this->native->tickets;
        $values = [ $user_id, $game_id ];

        $count = $table->ticket_id->name;
        $alias = 'used';
        $cols = [ "COUNT($count) AS $alias" ];
        $groups = [ $table->prize_id->name ];

        $sql = "SELECT ";
        $where = "{$table->deleted->name}=0 AND {$table->cancelled->name}=0";
        $where .= " AND {$table->user_id->name}=%d";
        $where .= " AND {$table->game_id->name}=%d";
        if ( $prize_id > 0 ) {
            $where .= " AND {$table->prize_id->name}=%d";
            $values[] = $prize_id;
        } else {
            $cols[] = $table->prize_id->name;
        }
        $sql .= implode(',', $cols) . " FROM {$table->name} WHERE $where GROUP BY " . implode(',', $groups);

        $results = $this->native->select( $sql, $values );

        return $this->getTicketRecords( $results );
    }

    public function countUserUnitTickets( $user_id, $game_id, $unit ) {
        $table = $this->native->tickets;

        $limit = TimeUnit::getDatetime( $unit );
        $limit_sql = $table->creation->getDatetimeValueAsString( $limit );

        $alias = 'used';
        //$groups = [ $table->prize_id->name ];

        $sql = "SELECT COUNT({$table->ticket_id->name}) AS $alias FROM {$table->name}";
        $sql .= " WHERE {$table->deleted->name}=0 AND {$table->cancelled->name}=0";
        $sql .= " AND {$table->user_id->name}=%d";
        $sql .= " AND {$table->game_id->name}=%d";
        $sql .= " AND {$table->creation->name}>=%s";

        $results = $this->native->select( $sql, $user_id, $game_id, $limit_sql );

        return $this->getTicketRecords( $results );
    }

    public function updateTicket( $data, $id ) {
        $table = $this->native->tickets;
        if ( $id > 0 ) {
            return $table->update( $data, [ 'ticket_id' => $id ] );
        } else {
            sosidee_log("Database.updateTicket() id is not greater than zero.");
            return false;
        }
    }

    private function _insertTicket( $data ) {
        $table = $this->native->tickets;
        return $table->insert( $data );
    }

    /**
     * insert a winning ticket and check the maximum number of possible wins
     * @param $data
     * @param $max int Total number of winning tickets
     * @return false|mixed array [prize id, ticket id]
     * @throws \Exception
     */
    public function insertTicket( $data, $max = false ) {
        $ret = false;
        try {
            if ( $max !== false ) {
                $this->native->transaction();
            }
            $prize_id = $data['prize_id'];
            $ticket_id = intval( $this->_insertTicket( $data ) );
            if ( $ticket_id > 0 ) {
                if ( $max !== false ) {
                    $game_id = $data['game_id'];
                    $results = $this->countTickets( $game_id, $prize_id );
                    if ( is_array($results) && count($results) == 1 ) {
                        $result = $results[0];
                        if ( $result->used <= $max ) {
                            $this->native->commit();
                            $ret = [ $prize_id, $ticket_id ];
                        } else {
                            $this->native->rollback();
                            $data['prize_id'] = 0; // convert the ticket into a losing one
                            $res = $this->updateTicket($data, $ticket_id);
                            if ( intval( $res ) > 0 ) {
                                sosidee_log("Database.updateTicket($ticket_id) returned '{$res}' after a rollback." );
                            }
                            $ret = [ 0, $ticket_id ];
                        }
                    } else {
                        $this->native->rollback();
                        sosidee_log('Database.countTickets() returned: ' . print_r( $results, true) );
                    }
                } else {
                    $ret = [ $prize_id, $ticket_id ];
                }
            } else {
                if ( $max !== false ) {
                    $this->native->rollback();
                }
                sosidee_log("Database._insertTicket() returned $ticket_id");
            }
        } catch (\Exception $ex) {
            if ( $max !== false ) {
                $this->native->rollback();
            }
            sosidee_log($ex);
            throw $ex;
        }
        return $ret;
    }

    public function deleteTicket( $id ) {
        return $this->native->tickets->update( [ 'deleted' => true ], [ 'ticket_id' => $id ] );
    }
    public function deleteTicketsByPrize( $prize_id ) {
        return $this->native->tickets->update( [ 'deleted' => true ], [ 'prize_id' => $prize_id ] );
    }
    public function deleteTicketsByGame( $game_id ) {
        return $this->native->tickets->update( [ 'deleted' => true ], [ 'game_id' => $game_id ] );
    }


    public function loadTickets( $filters ) {

        $table = $this->native->tickets;
        $values = [];

        $table_game = $this->native->games;
        $table_prize = $this->native->prizes;

        $sql = "SELECT {$table->name}.*";
        $sql .= ",{$table_game->name}.{$table_game->description->name} AS game";
        $sql .= ",{$table_prize->name}.{$table_game->description->name} AS prize";
        $sql .= " FROM {$table->name}";
        $sql .= " LEFT JOIN {$table_game->name} ON ({$table->name}.{$table->game_id->name} = {$table_game->name}.{$table_game->game_id->name} AND {$table_game->name}.{$table_game->deleted->name}=0)";
        $sql .= " LEFT JOIN {$table_prize->name} ON ({$table->name}.{$table->prize_id->name} = {$table_prize->name}.{$table_prize->prize_id->name} AND {$table_prize->name}.{$table_prize->deleted->name}=0)";

        $sql .= " WHERE {$table->name}.{$table->deleted->name}=0";
        if ( key_exists('game', $filters) && $filters['game'] > 0  ) {
            $sql .= " AND {$table_game->name}.{$table_game->game_id->name}=%d";
            $values[] = intval( $filters['game'] );
        }
        if ( key_exists('result', $filters) && $filters['result'] != ResultStatus::NONE  ) {
            $sql .= " AND {$table->name}.{$table->prize_id->name}";
            if ( $filters['result'] == ResultStatus::WIN ) {
                $sql .= ">0";
            } else if ( $filters['result'] == ResultStatus::LOSS ) {
                $sql .= "=0";
            }
        }
        if ( key_exists('status', $filters) && $filters['status'] != TicketStatus::NONE  ) {
            $sql .= " AND {$table->name}.{$table->cancelled->name}=%d";
            $values[] = boolval( $filters['status'] );
        }
        if ( key_exists('from', $filters) && $filters['from'] instanceof \DateTime  ) {
            $sql .= " AND {$table->name}.{$table->creation->name}>=%s";
            $values[] = $table->creation->getDatetimeValueAsString( $filters['from'] );
        }
        if ( key_exists('to', $filters) && $filters['to'] instanceof \DateTime  ) {
            $sql .= " AND {$table->name}.{$table->creation->name}<=%s";
            $values[] = $table->creation->getDatetimeValueAsString( $filters['to'] );
        }
        if ( key_exists('id', $filters) && $filters['id'] > 0  ) {
            $sql .= " AND {$table->name}.{$table->ticket_id->name}=%d";
            $values[] = intval( $filters['id'] );
        }

        $sql .= " ORDER BY {$table->name}.{$table->creation->name} DESC";

        $results = $this->native->select( $sql, $values );
        if ( is_array($results) ) {
            for ( $n=0; $n<count($results); $n++ ) {
                $column = &$results[$n];
                $column->ticket_id = intval( $column->ticket_id );
                $column->prize_id = intval( $column->prize_id );
                $column->game_id = intval( $column->game_id );
                $column->user_id = intval( $column->user_id );
                $column->creation = DATA\Db::getDatetimeFromString( $column->creation ); // trasformare Db in trait
                $column->cancelled = boolval( $column->cancelled );
                $column->deleted = boolval( $column->deleted );
                $column->prize = trim( $column->prize ); // convert null to empty string
                unset($column);
            }
        } else {
            sosidee_log("Database.loadTickets() did not return an array.");
        }

        return $results;
    }

    public function loadTicket( $id ) {
        $table = $this->native->tickets;
        $field = $table->ticket_id->name;

        $results = $table->select( [
            $field => $id
        ] );

        if ( is_array($results) ) {
            if ( count($results) == 1 ) {
                return $results[0];
            } else {
                sosidee_log("Database.loadTicket($id) :: WpTable.select() returned a wrong array length: " . count($results) . " (requested: 1)" );
                return false;
            }
        } else {
            return false;
        }

    }

    public function loadStatGames( $status ) {
        $ret = false;
        $filters = [];
        if ( $status != GameStatus::NONE ) {
            $filters[ 'status' ] = $status;
        }
        $games = $this->loadGames( $filters, ['creation' => 'DESC'] );
        if ( is_array($games) ) {
            for ( $i=0; $i<count($games); $i++ ) {
                $games[$i]->used = 0;
                $games[$i]->win = 0;
            }
            $tickets = $this->countTickets();
            if ( is_array($tickets) ) {
                for ( $i=0; $i<count($games); $i++ ) {
                    $game = &$games[$i];
                    for ( $j=0; $j<count($tickets); $j++ ) {
                        $ticket = $tickets[$j];
                        if ( $game->game_id == $ticket->game_id ) {
                            $game->used += $ticket->used;
                            if ( $ticket->prize_id > 0 ) {
                                $game->win += $ticket->used;
                            }
                        }
                    }
                    unset($game);
                }
                $ret = $games;
            } else {
                sosidee_log("Database.loadStatGames() :: countTickets() did not return an array.");
            }
        } else {
            sosidee_log("Database.loadStatGames() :: loadGames() did not return an array.");
        }
        return  $ret;
    }

    public function loadGameStat( $id ) {
        $game = $this->loadGame( $id );
        if ( $game !== false ) {
            $game->prizes = array();
            $game->used = 0;
            $prizes =  $this->loadPrizes( $id, true, ['description'] );
            if ( is_array($prizes) ) {
                for ( $i=0; $i<count($prizes); $i++ ) {
                    $prize = &$prizes[$i];
                    $prize->used = 0;
                }
                $tickets = $this->countTickets( $id );
                if ( is_array($tickets) ) {
                    for ( $j=0; $j<count($tickets); $j++ ) {
                        $game->used += $tickets[$j]->used;
                    }
                    for ( $i=0; $i<count($prizes); $i++ ) {
                        $prize = &$prizes[$i];
                        for ( $j=0; $j<count($tickets); $j++ ) {
                            $ticket = $tickets[$j];
                            if ( $prize->prize_id == $ticket->prize_id ) {
                                $prize->used = $ticket->used;
                                break;
                            }
                        }
                    }
                } else {
                    sosidee_log("Database.loadGameStat($id) :: countTickets($id) did not return an array.");
                }
                $game->prizes = $prizes;
            } else {
                sosidee_log("Database.loadGameStat($id) :: loadPrizes($id) did not return an array.");
            }
            return $game;
        } else {
            sosidee_log("Database.loadGameStat($id) :: loadGame($id) returned false.");
            return false;
        }
    }

}