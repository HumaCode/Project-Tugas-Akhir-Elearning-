
$('.page-scroll').on('click', function(e){

// ambil isi dari href
	var tujuan = $(this).attr('href');

// tangkap element yang bersangkutan 
	var elementTujuan = $(tujuan);
	
// pindahkan scroll
	$('html').animate({
		scrollTop: elementTujuan.offset().top - 50
	}, 1200, 'easeInOutExpo')

	e.preventDefault();
});

// PARALAX
// paralax ktika di refresh untuk about
/* jqueri carikan window yang ketika(on), di load/refreash/dibuka, 
	maka jalankan fungsi berikut */
	$(window).on('load', function(){
		$('.pKiri').addClass('pMuncul');
		$('.pKanan').addClass('pMuncul');
	});






