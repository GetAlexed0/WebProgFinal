'use strict';

function init() {
	var gespeichert = 'nichts gespeichert';
	if (document.cookie) {
		gespeichert = document.cookie;
	} else {
		document.cookie = 'Zeitstempel=' + document.lastModified;
	}
	var text = document.lastModified + ' - ' + gespeichert;
	ausgabe(text);
}

function ausgabe(text) {
	var ausgabe = document.getElementById('info');
	ausgabe.innerHTML = text;
}
window.addEventListener('DOMContentLoaded', init);
  