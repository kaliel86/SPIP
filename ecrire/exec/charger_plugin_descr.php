<?php

/***************************************************************************\
 *  SPIP, Systeme de publication pour l'internet                           *
 *                                                                         *
 *  Copyright (c) 2001-2007                                                *
 *  Arnaud Martin, Antoine Pitrou, Philippe Riviere, Emmanuel Saint-James  *
 *                                                                         *
 *  Ce programme est un logiciel libre distribue sous licence GNU/GPL.     *
 *  Pour plus de details voir le fichier COPYING.txt ou l'aide en ligne.   *
\***************************************************************************/

if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip('inc/plugin');

// Un morceau d'ajax qui affiche le descriptif d'un plugin a partir
// des listes de plugins a telecharger, dans exec=admin_plugin
// http://doc.spip.org/@exec_charger_plugin_descr_dist

function exec_charger_plugin_descr_dist() {
	exec_charger_plugin_descr_args( _request('url'));
}

function exec_charger_plugin_descr_args($url_plugin) {

	if (!autoriser('configurer', 'plugins')) {
		include_spip('inc/minipres');
		echo minipres();
	} else {

	if ($url_plugin) {
		include_spip('inc/charger_plugin');
		include_spip('inc/texte');
		$liste = liste_plugins_distants($url_plugin);
		$item = $liste[$url_plugin][2];
		include_spip('inc/presentation');
		echo debut_cadre_relief('', true);
		echo propre('<h3><multi>'
			.sinon($item['titre'], $liste[$url_plugin][0]).'</multi></h3>'
			.'<multi>'.$item['descriptif'].'</multi>'
			.$item['lesauteurs']. ' '
			. ($item['tags']
				? "<p>".join(' &mdash; ',$item['tags'])."</p>\n"
				:'')
			. propre('[->'.$liste[$url_plugin][1].']')
			);
		echo fin_cadre_relief(true);
	}
	}
}

?>
