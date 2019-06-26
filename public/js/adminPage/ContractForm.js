class ContractForm {
	constructor(domElt) {
		this.productContainer = domElt.productContainer;
		this.productAddElt = domElt.productAddElt;
		this.tableElt = domElt.tableElt;
		this.tableBodyElt = domElt.tableBodyElt;
		this.tableBodyRowElt = domElt.tableBodyRowElt;
		this.selectElt = domElt.selectElt;
		this.imageInput = domElt.imageInput;
		this.handleEmbeddedProductForm();
		this.removeImageStyle();
	}

	handleEmbeddedProductForm() {
		this.productPrototype = $(this.productContainer).attr('data-prototype');
		this.productIndex = $(this.productContainer).find('fieldset').length;
		let self = this;

		if (this.productIndex !== 0) {
			$(this.productContainer).children('fieldset').each(function(i) {
				self.addTableLine(i, $(this));
				self.listenChangedValue(i);
				self.customizeSelectBox();
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
		
		let productForm = this.addDeleteButton(newProductPrototype);
		$(this.productContainer).append(productForm);
		this.listenChangedValue(this.productIndex);
		this.customizeSelectBox();
		this.productIndex++;
	}

	addDeleteButton(prototype) {
		let $deleteButton = $('<a href="#"><span class="btn btn-danger fas fa-times"> Supprimer</span></a>');
		let prototypeWithDeleteButton = $(prototype).append($deleteButton);

		let self = this;
		$deleteButton.click(function(e) {
			e.preventDefault();
			$(prototypeWithDeleteButton).fadeOut(500, function() {
				$(this).remove();
				self.productIndex--;
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
			$(prototype).fadeToggle(500);
		});

		$deleteLink.click(function(e) {
			e.preventDefault();
			self.productIndex--;

			$(prototype).fadeOut(500, function() {
				$(this).remove();
			});

			$line.fadeOut(500, function() {
				$(this).remove();
			});

			if (self.productIndex === 0) {
				$(self.tableElt).fadeOut(500);
			}
		});
	}

	listenChangedValue(i) {
		let $deliveryBool = $('#contract_products_' + i + '_is_variable_delivery');
		let $nbDelivery = $('#contract_products_' + i + '_nb_delivery');
		let $priceBool = $('#contract_products_' + i + '_is_fixed_price');
		let $fixedPrice = $('#contract_products_' + i + '_fixed_price');
		let $minPrice = $('#contract_products_' + i + '_min_price');
		let $maxPrice = $('#contract_products_' + i + '_max_price');

		if ($deliveryBool.val() === '0') {
			$nbDelivery.attr('disabled', 'true');
		}
		
		if ($priceBool.val() === '0') {
			$fixedPrice.attr('disabled', 'true');
		}
		else if ($priceBool.val() === '1') {
			$minPrice.attr('disabled', 'true');
			$maxPrice.attr('disabled', 'true');
		}

		$deliveryBool.change(function() {
			let value = $(this).val();
			if (value === '1') {
				$nbDelivery.removeAttr('disabled');
			}
			else {
				$nbDelivery.attr('disabled', 'true');
				$nbDelivery.val('');
			}
		});

		$priceBool.change(function() {
			let value = $(this).val();
			if (value === '1') {
				$fixedPrice.removeAttr('disabled');
				$minPrice.attr('disabled', 'true');
				$minPrice.val('');
				$maxPrice.attr('disabled', 'true');
				$maxPrice.val('');
			}
			else {
				$fixedPrice.attr('disabled', 'true');
				$fixedPrice.val('');
				$minPrice.removeAttr('disabled');
				$maxPrice.removeAttr('disabled');
			}
		});
	}

	customizeSelectBox() {
		$(this.selectElt).siblings('select').select2();
	}

	removeImageStyle() {
		$(this.imageInput).removeClass('custom-file-input');
		let $label = $(this.imageInput).siblings('label');
		$label.removeClass('custom-file-label');
	}
}

$(function() {
	let domElt = {
		productContainer: '#contract_products',
		productAddElt: '#add-product',
		tableElt: 'table',
		tableBodyElt: 'tbody',
		tableBodyRowElt: 'tbody tr',
		selectElt: '.foodTypes',
		imageInput: '#contract_image_file'
	}
	const contractForm = new ContractForm(domElt);
});