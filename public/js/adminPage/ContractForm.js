class ContractForm {
	constructor(domElt) {
		this.summaryElt = domElt.summaryElt;
		this.descriptionElt = domElt.descriptionElt;
		this.growerNameElt = domElt.growerNameElt;
		this.gpsLatElt = domElt.gpsLatElt;
		this.gpsLngElt = domElt.gpsLngElt;
		this.productContainer = domElt.productContainer;
		this.productAddElt = domElt.productAddElt;
		this.displayPlaceholders();
		this.handleEmbeddedProductForm();
	}

	displayPlaceholders() {
		$(this.summaryElt).attr('placeholder', 'Le résumé du contrat sera affiché sur la page d\'accueil et sur la page listant les contrats.');
		$(this.descriptionElt).attr('placeholder', 'La description du contrat sera affiché sur la page du contrat.');
		$(this.growerNameElt).attr('placeholder', 'Le nom renseigné ici servira également de description pour le marqueur de la carte.');
		$(this.gpsLatElt).attr('placeholder', 'Exemple de latitude: 48.862725');
		$(this.gpsLngElt).attr('placeholder', 'Exemple de longitude: 2.287592');
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
}

$(function() {
	let domElt = {
		summaryElt: '#contract_summary',
		descriptionElt: '#contract_description',
		growerNameElt: '#contract_grower_name',
		gpsLatElt: '#contract_grower_gps_lat',
		gpsLngElt: '#contract_grower_gps_lng',
		productContainer: '#contract_products',
		productAddElt: '#add-product'
	}
	const contractForm = new ContractForm(domElt);
});