<?php
/*
Plugin Name: Générateur de Passcode APRS
Plugin URI: http://f4hxn.fr
Description: Un générateur de passcode APRS pour WordPress.
Version: 1.0
Author: F4HXN Mansouri Jean-Paul
Author URI: http://f4hxn.fr
License: GPL2
*/

function aprs_passcode_generator_script() {
    ?>
    <script>
    function aprspass() {
        var callsign = document.getElementById('aprs-callsign').value;
        var stophere = callsign.indexOf('-');
        if (stophere !== -1) callsign = callsign.substring(0, stophere);
        var realcall = callsign.toUpperCase().substring(0, 10);

        var hash = 0x73e2;
        var i = 0;
        var len = realcall.length;

        while (i < len) {
            hash ^= realcall.charCodeAt(i) << 8;
            if (i + 1 < len) {
                hash ^= realcall.charCodeAt(i + 1);
            }
            i += 2;
        }

        var passcode = hash & 0x7fff;
        document.getElementById('aprs-passcode-result').innerText = "Passcode APRS : " + passcode;
    }
    </script>
    <?php
}

function aprs_passcode_generator_shortcode() {
    aprs_passcode_generator_script();
    ob_start();
    ?>
    <div>
    <b>
            
        <label for="aprs-callsign">Indicatif:</label>
        <input type="text" id="aprs-callsign" name="callsign">
        <button onclick="aprspass()">Générer Mot de passe</button>
        <p id="aprs-passcode-result"></p>
        
     
    </b> 
    </div>
    <?php
    return ob_get_clean();
}

add_shortcode('aprs_passcode_generator', 'aprs_passcode_generator_shortcode');

