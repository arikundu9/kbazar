$(document).on('click',function(e){
	//console.log($(e.target).attr('id'));
	if( $(e.target).attr('id') != 'pids' ){
		if($("[data-target='#navbarCollapse']").is("[aria-expanded='true']")){
			$("#navbarCollapse").collapse('hide');
		}
		if($("[data-target='#navbarCollapse2']").is("[aria-expanded='true']")){
			$("#navbarCollapse2").collapse('hide');
		}
	}
});
