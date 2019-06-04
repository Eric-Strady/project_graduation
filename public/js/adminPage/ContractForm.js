class ContractForm {
	constructor(domElt) {
		this.productContainer = domElt.productContainer;
		this.productAddElt = domElt.productAddElt;
		this.selectElt = domElt.selectElt;
		this.handleEmbeddedProductForm();
	}

	handleEmbeddedProductForm() {
		this.productPrototype = $(this.productContainer).attr('data-prototype');
		this.productIndex = $(this.productContainer).find('fieldset').length;
		console.log(this.productIndex);
		let self = this;

		if (this.productIndex !== 0) {
			$(this.productContainer).children('fieldset').each(function() {
				self.addDeleteLink($(this));
			});
		}

		$(this.productAddElt).click(function(e) {
			e.preventDefault();
			self.addProductForm();
		});
	}

	addProductForm() {
		let newProductPrototype = this.productPrototype.replace(/__name__/g, this.productIndex);
		this.productIndex++;

		let productForm = this.addDeleteLink(newProductPrototype);
		$(this.productAddElt).before(productForm);
		this.customizeSelectBox();
	}

	addDeleteLink(prototype) {
		let $deleteLink = $('<a href="#"><span class="btn btn-danger fas fa-times"> Supprimer</span></a>');
		let prototypeWithDeleteLink = $(prototype).append($deleteLink);

		$deleteLink.click(function(e) {
			e.preventDefault();
			$(prototypeWithDeleteLink).fadeOut(500, function() {
				$(this).remove();
			});
		});

		return prototypeWithDeleteLink;
	}

	customizeSelectBox(){
		$(this.selectElt).select2();
	}
}

$(function() {
	let domElt = {
		productContainer: '#contract_products',
		productAddElt: '#add-product',
		selectElt: 'select'
	}
	const contractForm = new ContractForm(domElt);
});