$(window).on("load", function(event) {
	switchEditor($("select[name='editor']").val(), 'textarea[name="content"]');
});