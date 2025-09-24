// resources/js/app.js
import * as bootstrap from 'bootstrap';

	/**
	* 
	* @var Tooltip
	* 
	*/
	var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
	var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
	return new bootstrap.Tooltip(tooltipTriggerEl)
	})

	/**
	* 
	* @var popover
	* 
	*/
	const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
	const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))


	/**
	* modal timing close
	* 
	* @return
	*/
	
$(document).ready(function() {
  $('.openModalBtn').click(function(e) {
    e.preventDefault();
    const modalId = $(this).data('modal-id');

    // Trouve l'accordéon ouvert (collapse avec class 'show')
    const openAccordion = $('.accordion-collapse.show');

    if (openAccordion.length) {
      // Ferme l'accordéon ouvert
      openAccordion.collapse('hide');

      // Quand la fermeture est terminée, ouvrir la modal
      openAccordion.one('hidden.bs.collapse', function() {
        $('#' + modalId).modal('show');
      });
    } else {
      // Aucun accordéon ouvert, ouverture directe de la modal
      $('#' + modalId).modal('show');
    }
  });
});


	
	
	