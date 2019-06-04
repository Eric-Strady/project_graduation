class PostFilter {
	constructor(domElt) {
		this.yearElt = domElt.yearElt;
		this.selectElt = domElt.selectElt;
		this.displayPlaceholder();
	}

	displayPlaceholder()
	{
		$(this.yearElt).attr('placeholder', 'Exemple année: 2019');
		$(this.selectElt).select2({
		    placeholder: "Exemple catégorie: Livraisons"
		});
	}
}

$(function() {
	let domElt = {
		yearElt: '#year',
		selectElt: 'select'
	};

	const postFilter = new PostFilter(domElt);
});