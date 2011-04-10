<?php
/**
 * Description of Profiler_Output
 *
 * @author Rémy Böhler
 */
class Profiler_Output {
    public static function htmlTable($return = false)
    {
        $html = '';

        if ($timers = Profiler::getTimers()) {
            $html .= '
                <table class="profiler-output-table" style="font-family:monospace;font-size:11px;" cellpadding="2">
                <tr>
                    <th>name</th>
                    <th>comment</th>
                    <th>duration</th>
                    <th>realmem</th>
                    <th>emalloc</th>
                </tr>
            ';
            foreach ($timers as $timer) {
                $sub = '';
                $duration = $realmem = $emalloc = 0;
                foreach ($timer['profiles'] as $profile) {
                    $duration += $profile['duration'];
                    $realmem += $profile['realmem'];
                    $emalloc += $profile['emalloc'];
                    $sub .= '
                        <tr>
                            <td>&nbsp;</td>
                            <td>'.$profile['comment'].'</td>
                            <td>'.sprintf('%.5f', $profile['duration']).'</td>
                            <td align="right">'.($profile['realmem']).'</td>
                            <td align="right">'.($profile['emalloc']).'</td>
                        </tr>
                    ';
                }
                $html .= '
                <tr style="background-color:#EFEFEF;">
                    <th>'.$timer['name'].'</th>
                    <th>count: '.count($timer['profiles']).'</th>
                    <th>'.sprintf('%.5f', $duration).'</th>
                    <th align="right">'.($realmem).'</th>
                    <th align="right">'.($emalloc).'</th>
                </tr>
                '.$sub;
            }
            $html .= '</table>';
        }

        if ($return) {
            return $html;
        }
        echo $html;
    }
}

