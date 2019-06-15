class Simulator {
	constructor(domElt) {
		this.inputNbAdult = domElt.inputNbAdult;
		this.inputNbChild = domElt.inputNbChild;
		this.selectedFoodTypeOption = domElt.selectedFoodTypeOption;
		this.errorNbAdultElt = domElt.errorNbAdultElt;
		this.errorNbChildElt = domElt.errorNbChildElt;
		this.errorProductElt = domElt.errorProductElt;
		this.secondStepContainer = domElt.secondStepContainer;
		this.productsFoodTypes = domElt.productsFoodTypes;
		this.resultContainer = domElt.resultContainer;
		this.nextStepButton = domElt.nextStepButton;
		this.simulateButton = domElt.simulateButton;
		this.handleSimulator();
		this.handleEvents();
	}

	handleSimulator() {
		$(this.secondStepContainer).hide();
		$(this.resultContainer).hide();
	}

	handleEvents() {
		let self = this;
		$(this.nextStepButton).click(function(e) {
			e.preventDefault();
			let checked = self.checkFirstStepData();

			if (checked) {
				$(self.secondStepContainer).fadeIn(500);
				self.disableNotMatchProducts();
			}
		});

		$(this.simulateButton).click(function(e) {
			e.preventDefault();
			let checkedInput = $(self.secondStepContainer).find('input:checked');
			let isValidData = self.checkSecondStepData(checkedInput);

			if (isValidData) {
				$(self.resultContainer).fadeIn(500);
				self.simulate(checkedInput);
			}
		});
	}

	checkFirstStepData() {
		let errorMessage = ' Cette valeur n\'est pas valide.';
		let isValid = true;

		let nbAdult = Number($(this.inputNbAdult).val());
		if (isNaN(nbAdult) || nbAdult < 1 || nbAdult > 10) {
			$(this.inputNbAdult).addClass('errorSimulator');
			this.addError(this.errorNbAdultElt, errorMessage);
			isValid = false;
		}
		else {
			this.removeError(this.errorNbAdultElt);
			$(this.inputNbAdult).removeClass('errorSimulator');
		}

		let nbChild = parseInt($(this.inputNbChild).val());
		if (isNaN(nbChild) || nbChild < 0 || nbChild > 10) {
			$(this.inputNbChild).addClass('errorSimulator');
			this.addError(this.errorNbChildElt, errorMessage);
			isValid = false;
		}
		else {
			this.removeError(this.errorNbChildElt);
			$(this.inputNbChild).removeClass('errorSimulator');
		}

		return isValid;
	}

	checkSecondStepData(checkedInput) {
		let errorMessage = ' Le ou les produits sélectionnés ne sont pas valides.';
		let isValid = true;

		let self = this;
		$(checkedInput).each(function(){
			let productId = Number($(this).val());
			if (isNaN(productId)) {
				self.addError(self.errorProductElt, errorMessage);
				isValid = false;
			}
			else {
				self.removeError(self.errorProductElt);
			}
		});

		return isValid;
	}

	disableNotMatchProducts() {
		let selectedFoodType = $(this.selectedFoodTypeOption).text();
		$(this.productsFoodTypes).each(function() {
			let $currentContract = $(this).parents('.contract');
			let nbProducts = $currentContract.find('.productChoice').length;
			
			$currentContract.show();
			$(this).parent().show();
			let isMatched = false;

			$(this).children('span').each(function() {
				if ($(this).text() === selectedFoodType) {
					isMatched = true;
				}
			});

			if (isMatched === false) {
				$(this).parent().hide();
				nbProducts--;
			}

			if (nbProducts === 0) {
				$currentContract.hide();
			}
		});
	}

	simulate(checkedInput) {
		let choices = [];
		$(checkedInput).each(function() {
			choices.push($(this).val());
		});
		
		console.log(choices);
	}

	addError(errorContainer, errorMessage) {
		this.removeError(errorContainer);

		let $spanContainer = $('<span class="invalid-feedback d-block"></span>');
		let $spanSubCntainer = $('<span class="d-block"></span>');
		let $spanBadgeError = $('<span class="form-error-icon badge badge-danger text-uppercase">Erreur</span>');
		let $spanMessage = $('<span class="form-error-message">' + errorMessage + '</span>');

		let $blockError = $spanContainer.append($spanSubCntainer);
		let $completeBlockError = $blockError.append($spanBadgeError, $spanMessage);

		$(errorContainer).append($completeBlockError);
	}

	removeError(errorContainer) {
		let $messageContainer = $(errorContainer).children('.invalid-feedback');
		if ($messageContainer) {
			$messageContainer.remove();
		}
	}
}

$(function() {
	let domElt = {
		inputNbAdult: '#simulator_nb_adult',
		inputNbChild: '#simulator_nb_child',
		selectedFoodTypeOption: '#simulator_food_type option:selected',
		errorNbAdultElt: '#nbAdultError',
		errorNbChildElt: '#nbChildError',
		errorProductElt: '#productError',
		secondStepContainer: '#secondStep',
		productsFoodTypes: '.foodTypes',
		resultContainer: '#result',
		nextStepButton: '#nextStep',
		simulateButton: '#simulate'
	}
	
	const simulator = new Simulator(domElt);
});