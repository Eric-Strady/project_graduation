class PostForm {
	constructor(domElt) {
		this.imageInput = domElt.imageInput;
		this.removeImageStyle();
	}

	removeImageStyle() {
		$(this.imageInput).removeClass('custom-file-input');
		let $label = $(this.imageInput).siblings('label');
		$label.removeClass('custom-file-label');
	}
}

$(function() {
	let domElt = {
		imageInput: '#post_image_file',
	}
	const postForm = new PostForm(domElt);
});