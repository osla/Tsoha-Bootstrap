//kun sivu on latautunut kutsutaan ready-funktion parametrina annettua funktiota
$(document).ready(function(){
	$('form.destroy-form').on('submit', function(submit){
		var confirm_message = $(this).attr('data-confirm');
		if(!confirm(confirm_message)){
			//jos käyttäjä ei anna vahvistusta, ei lähetetä lomaketta
			submit.preventDefault();
		}
	});
});
