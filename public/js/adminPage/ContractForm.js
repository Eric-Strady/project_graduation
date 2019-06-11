class ContractForm {
	constructor(domElt) {
		this.productContainer = domElt.productContainer;
		this.productAddElt = domElt.productAddElt;
		this.tableElt = domElt.tableElt;
		this.tableBodyElt = domElt.tableBodyElt;
		this.tableBodyRowElt = domElt.tableBodyRowElt;
		this.selectElt = domElt.selectElt;
		this.handleEmbeddedProductForm();
	}

	handleEmbeddedProductForm() {
		this.productPrototype = $(this.productContainer).attr('data-prototype');
		this.productIndex = $(this.productContainer).find('fieldset').length;
		let self = this;

		if (this.productIndex !== 0) {
			$(this.productContainer).children('fieldset').each(function(i) {
				self.addTableLine(i, $(this));
				$(this).hide();
				i++;
			});
		}
		else
		{
			$(this.tableElt).hide();
		}

		$(this.productAddElt).click(function(e) {
			e.preventDefault();
			self.addProductForm();
		});
	}

	addProductForm() {
		let newProductPrototype = this.productPrototype.replace(/__name__/g, this.productIndex);
		this.productIndex++;

		let productForm = this.addDeleteButton(newProductPrototype);
		$(this.productContainer).append(productForm);
		this.customizeSelectBox();
	}

	addDeleteButton(prototype) {
		let $deleteButton = $('<a href="#"><span class="btn btn-danger fas fa-times"> Supprimer</span></a>');
		let prototypeWithDeleteButton = $(prototype).append($deleteButton);

		$deleteButton.click(function(e) {
			e.preventDefault();
			$(prototypeWithDeleteButton).fadeOut(500, function() {
				$(this).remove();
			});
		});

		return prototypeWithDeleteButton;
	}

	addTableLine(i, prototype) {
		let tableIndex = i + 1;
		let name = $('#contract_products_' + i + '_name').val();
		let $line = $('<tr><th>' + tableIndex + '</th><td class="name">' + name + '</td></tr>');

		let $td = $('<td></td>');
		let $updateLink = $('<a class="mr-2" href="#"><span class="btn btn-primary fas fa-pen"></span></a>');
		let $deleteLink = $('<a class="mr-2" href="#"><span class="btn btn-danger fas fa-times"></span></a>');

		let actionsLink = $td.append($updateLink, $deleteLink);
		let tableLine = $line.append(actionsLink);
		$(this.tableBodyElt).append(tableLine);

		let self = this;
		$updateLink.click(function(e) {
			e.preventDefault();
			$(prototype).fadeIn(500);
		});

		$deleteLink.click(function(e) {
			e.preventDefault();
			$(prototype).fadeOut(500, function() {
				$(this).remove();
			});

			$line.fadeOut(500, function() {
				$(this).remove();
			});

			if ($(self.tableBodyRowElt).length === 1) {
				$(self.tableElt).fadeOut(500);
				self.productIndex = 0;
			}
		});
	}

	customizeSelectBox() {
		$(this.selectElt).select2();
	}
}

$(function() {
	let domElt = {
		productContainer: '#contract_products',
		productAddElt: '#add-product',
		tableElt: 'table',
		tableBodyElt: 'tbody',
		tableBodyRowElt: 'tbody tr',
		selectElt: 'select'
	}
	const contractForm = new ContractForm(domElt);
});