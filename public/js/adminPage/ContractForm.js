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

		let productForm = this.addValidateButton(newProductPrototype);
		$(this.productContainer).append(productForm);
		this.customizeSelectBox();
	}

	addValidateButton(prototype) {
		let $validateButton = $('<a href="#"><span class="btn btn-primary fas fa-check"> Ajouter</span></a>');
		let prototypeWithValidateButton = $(prototype).append($validateButton);
		let prototypeChildrenId = $(prototype).children('div').attr('id');
		let prototypeIndex = Number(prototypeChildrenId.slice(-1));

		let self = this;
		$validateButton.click(function(e) {
			e.preventDefault();
			$(prototypeWithValidateButton).fadeOut(500, function() {
				self.addTableLine(prototypeIndex , $(this));
			});
		});

		return prototypeWithValidateButton;
	}

	addTableLine(i, prototype) {
		let tableIndex = i + 1;
		let name = $('#contract_products_' + i + '_name').val();
		let $line = $('<tr><th>' + tableIndex + '</th><td>' + name + '</td></tr>');

		let $td = $('<td></td>');
		let $editLink = $('<a class="mr-2" href="#"><span class="btn btn-primary fas fa-pen"></span></a>');
		let $deleteLink = $('<a class="mr-2" href="#"><span class="btn btn-danger fas fa-times"></span></a>');

		let actionsLink = $td.append($editLink, $deleteLink);
		let tableLine = $line.append(actionsLink);
		$(this.tableBodyElt).append(tableLine);

		$editLink.click(function(e) {
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

			//if ($(this.tableBodyElt + ' tr').length < 0) {
			//	$(self.tableElt).fadeOut(500);
			//}
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