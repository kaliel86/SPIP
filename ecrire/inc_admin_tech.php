<?php

/***************************************************************************\
 *  SPIP, Systeme de publication pour l'internet                           *
 *                                                                         *
 *  Copyright (c) 2001-2006                                                *
 *  Arnaud Martin, Antoine Pitrou, Philippe Riviere, Emmanuel Saint-James  *
 *                                                                         *
 *  Ce programme est un logiciel libre distribue sous licence GNU/GPL.     *
 *  Pour plus de details voir le fichier COPYING.txt ou l'aide en ligne.   *
\***************************************************************************/

if (!defined("_ECRIRE_INC_VERSION")) return;

include_ecrire("inc_presentation");

function admin_tech_dist()
{
  global $connect_statut, $connect_toutes_rubriques, $couleur_foncee, $flag_gz, $options;

debut_page(_T('titre_admin_tech'), "administration", "base");


echo "<br>";

if ($options == "avancees") {
	echo "<br><br>";
	gros_titre(_T('titre_admin_tech'));
	barre_onglets("administration", "sauver");
}


debut_gauche();

debut_boite_info();

echo _T('info_gauche_admin_tech');

fin_boite_info();

debut_droite();

if ($connect_statut != '0minirezo' OR !$connect_toutes_rubriques) {
	echo _T('avis_non_acces_page');
	fin_page();
	exit;
}

//
// Sauvegarde de la base
//

debut_cadre_relief();

echo "<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=5 WIDTH=\"100%\">";
echo "<TR><TD BGCOLOR='$couleur_foncee' BACKGROUND=''><B>";
echo "<FONT FACE='Verdana,Arial,Sans,sans-serif' SIZE=3 COLOR='#FFFFFF'>";
echo _T('texte_sauvegarde')."</FONT></B></TD></TR>";

echo "<tr><td class='serif'>";

echo "\n<form action='" . generer_url_ecrire("export_all","") . "' method='get'>";

echo "\n<p align='justify'>";
echo http_img_pack('warning.gif', _T('info_avertissement'), "width='48' height='48' align='right'");
echo _T('texte_admin_tech_01');

echo "<p>"._T('texte_admin_tech_02');

if ($flag_gz) {
	echo "\n<p align='justify'>"._T('texte_admin_tech_03')."<p>";
	echo "\n<INPUT TYPE='radio' NAME='gz' VALUE='1' id='gz_on' CHECKED><label for='gz_on'> "._T('bouton_radio_sauvegarde_compressee')." </label><BR>\n";
	echo "\n<INPUT TYPE='radio' NAME='gz' VALUE='0' id='gz_off'><label for='gz_off'> "._T('bouton_radio_sauvegarde_non_compressee')." </label><BR>\n";
}
else {
	echo "\n<p align='justify'>"._T('texte_sauvegarde_compressee');
	echo "\n<INPUT TYPE='hidden' NAME='gz' VALUE='0'>";
}

echo "\n<p><DIV align='right'><INPUT CLASS='fondo' TYPE='submit' VALUE='"._T('texte_sauvegarde_base')."'></FORM></DIV>";

echo "</td></tr>";
echo "</TABLE>";


//
// Restauration de la base
//

echo "<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=8 WIDTH=\"100%\">";
echo "<TR><TD BGCOLOR='#EEEECC' BACKGROUND=''><B>";
echo "<FONT FACE='Verdana,Arial,Sans,sans-serif' SIZE=3 COLOR='#000000'>";
echo _T('texte_restaurer_base')."</FONT></B></TD></TR>";

echo "<TR><td class='serif'>";

echo "\n<form action='" . generer_url_ecrire("import_all","") . "' method='get'>";

echo "\n<p align='justify'> "._T('texte_restaurer_sauvegarde');


if ($flag_gz) {
	$fichier_defaut = 'dump.xml.gz';
	$texte_compresse = _T('texte_compresse_ou_non')."&nbsp;";
}
else {
	$fichier_defaut = 'dump.xml';
	$texte_compresse = _T('texte_non_compresse')."&nbsp;";
}

echo "\n<p>"._T('entree_nom_fichier', array('texte_compresse' => $texte_compresse));
echo "\n<p><FONT SIZE=3><ul><INPUT TYPE='text' NAME='archive' VALUE='$fichier_defaut' SIZE='30'></ul></FONT>";

echo "\n<p><DIV align='right'><INPUT CLASS='fondo' TYPE='submit' NAME='valider' VALUE='"._T('bouton_restaurer_base')."'></DIV></FORM>";

echo "</td></tr>";
echo "</TABLE>";


//
// Lien vers la reparation
//

if ($options == "avancees") {
	$res = spip_query("SELECT version()");
	if (($row = spip_fetch_array($res)) AND ($row[0] >= '3.23.14')) {
		echo "<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=8 WIDTH=\"100%\">";
		echo "<TR><TD BGCOLOR='#EEEECC' BACKGROUND=''><B>";
		echo "<FONT FACE='Verdana,Arial,Sans,sans-serif' SIZE=3 COLOR='#000000'>";
		echo _T('texte_recuperer_base')."</FONT></B></TD></TR>";

		echo "<TR><TD class='serif'>";

		echo "\n<form action='" . generer_url_ecrire("admin_repair","") . "' method='get'>";

		echo "\n<p align='justify'>"._T('texte_crash_base');

		echo "\n<p><DIV align='right'><INPUT CLASS='fondo' TYPE='submit' NAME='valider' VALUE='"._T('bouton_tenter_recuperation')."'></DIV></FORM>";

		echo "</TD></TR>";
		echo "</TABLE>";
	}
}


fin_cadre_relief();

echo "<BR>";




fin_page();
}

?>
