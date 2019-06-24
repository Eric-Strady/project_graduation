class Tinymce {
	constructor(selector) {
		this.selector = selector;
		this.displayTextEditor();
	}

	displayTextEditor(){
		tinymce.init({
			selector:this.selector,
    		height: 300,
    		language: 'fr_FR',
			plugins: 'autosave preview autolink link pagebreak nonbreaking advlist lists textcolor wordcount contextmenu colorpicker help',
			block_formats: 'Paragraph=p;Heading 3=h3;Heading 4=h4;Heading 5=h5;Heading 6=h6',
			toolbar: 'formatselect | bold italic strikethrough forecolor | link | alignleft aligncenter alignright alignjustify | numlist bullist outdent indent | removeformat'
		});
	}
}

$(function() {
	const tinymce = new Tinymce(selector);
});