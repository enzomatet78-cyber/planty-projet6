/**
 * Page Commander : boutons + / − et bouton Ok de chaque parfum.
 *
 * Chaque parfum possède un bloc .parfum-choix qui contient :
 *   - le champ quantité, généré par Contact Form 7 ;
 *   - un bouton + et un bouton − pour changer la quantité ;
 *   - un bouton Ok pour confirmer le choix.
 *
 * Le fichier est chargé en bas de page (voir functions.php) : quand il
 * s'exécute, le HTML du formulaire est déjà là.
 */
document.querySelectorAll( '.parfum-choix' ).forEach( function ( bloc ) {

	var champ = bloc.querySelector( 'input[type="number"]' );
	var plus  = bloc.querySelector( '.qte-plus' );
	var moins = bloc.querySelector( '.qte-moins' );
	var ok    = bloc.querySelector( '.parfum-ok' );

	// Remet le bouton Ok en accord avec la quantité :
	// inutilisable tant qu'elle vaut 0, et « non confirmé » dès qu'elle change.
	function mettreAJour() {
		var quantite = parseInt( champ.value, 10 ) || 0;
		ok.disabled = quantite <= 0;
		ok.setAttribute( 'aria-pressed', 'false' );
	}

	// stepUp() et stepDown() sont des méthodes natives du champ nombre :
	// elles ajoutent ou retirent 1 en respectant le min (0) et le max (99).
	plus.addEventListener( 'click', function () {
		champ.stepUp();
		mettreAJour();
	} );

	moins.addEventListener( 'click', function () {
		champ.stepDown();
		mettreAJour();
	} );

	// Le client peut aussi taper la quantité au clavier.
	champ.addEventListener( 'input', mettreAJour );

	// Ok : confirme le choix. Le CSS affiche alors la coche et le rose foncé.
	ok.addEventListener( 'click', function () {
		ok.setAttribute( 'aria-pressed', 'true' );
	} );

	// Après un envoi réussi, Contact Form 7 remet le formulaire à zéro.
	// L'événement « reset » part juste AVANT la remise à zéro : on attend
	// qu'elle soit faite (setTimeout 0) pour recalculer l'état des boutons.
	champ.form.addEventListener( 'reset', function () {
		setTimeout( mettreAJour, 0 );
	} );

	mettreAJour(); // état de départ : quantité 0, Ok désactivé
} );
