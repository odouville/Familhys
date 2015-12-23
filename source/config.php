<?php

$cfg = array();

// Définit le temps (en secondes) au bout duquel un utilisateur qui a fermé toutes les pages du site se voit déconnecté
// Valeur par défaut : 300 (5 minutes)
$cfg['timeout_session'] = 300;

$cfg['a'] = 1;


// Mapping d'activités Noethys
// Pour les types des unités de réservations :
// 0 : standard (1 réservation à la fois)
// 1 : 
$cfg['activites'] = array(
		1 => array(
				'code' => 'Cantine',
				'unites_reservation' => array(
						1 => array(
								'code' => 'Rep',
								'libelle' => 'Repas',
								'type' => 0
							)
					)
			),
		5 => array(
				'code' => 'Garderie',
				'unites_reservation' => array(
						1 => array(
								'code' => 'Rep',
								'libelle' => 'Repas',
								'type' => 0
							)
					)
			)
	);
$cfg['unites_reservation'] = array(
	1 => array(
		'code' => 'REP',
		'libelle' => 'Repas cantine',
		'unites' => array(
			1 => array(1)
		)
	),
	5 => array(
		'code' => 'GRD',
		'libelle' => 'Place de garderie',
		'unites' => array(
			5 => array(36,37,38,39,40,43,44,45,46,47,48)
		)
	)
);




/******************************************************************************/
/*                                                                            */
/*              NE RIEN MODIFIER CI-DESSOUS                                   */
/*                                                                            */
/******************************************************************************/

// Gestion des valeurs minimales et maximales si nécessaire
if ($cfg['timeout_session'] < 60) $cfg['timeout_session'] = 60;

?>