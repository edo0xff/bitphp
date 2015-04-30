<?php

    /**
    *   @author Eduardo B <ms7rbeta@gmail.com>
    */
    class TimeDiff
    {
    /**
     *  timeDff
     *  Devuelve la diferencia de tiempo entre una fecha y el tiempo actual
     *
     *  @param String $string_date      *fecha que se va a comparar*
     *  @return String
     */
        public static function getTimeAgo( $string_date ) {

            $date_1 = new DateTime($string_date);
            $date_2 = new DateTime();

            $interval = $date_1->diff($date_2);

            $seconds_ago = $interval->format('%s');
            $mins_ago = $interval->format('%i');
            $hours_ago = $interval->format('%h');
            $days_ago = $interval->format('%a');

            if((int)$days_ago > 1) {
                $time_ago = date('j F, Y',strtotime($string_date));
            } else if((int)$hours_ago > 1) {
                $time_ago = 'Hace '.$hours_ago.' horas';
            } else if((int)$mins_ago > 1 && (int)$mins_ago < 59) {
                $time_ago = 'Hace '.$mins_ago.' mins';
            } else if((int)$seconds_ago > 5 && (int)$seconds_ago < 59) {
                $time_ago = 'Hace ' . $seconds_ago.' segs';
            } else {
                $time_ago = 'Hace unos segundos';
            }

            return $time_ago;
        }
    }
?>