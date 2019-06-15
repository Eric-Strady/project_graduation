class Simulator {
	constructor(domElt) {
		this.inputNbAdult = domElt.inputNbAdult;
		this.inputNbChild = domElt.inputNbChild;
		this.selectedFoodTypeOption = domElt.selectedFoodTypeOption;
		this.inputEmail = domElt.inputEmail;
		this.errorNbAdultElt = domElt.errorNbAdultElt;
		this.errorNbChildElt = domElt.errorNbChildElt;
		this.errorProductElt = domElt.errorProductElt;
		this.errorEmailElt = domElt.errorEmailElt;
		this.secondStepContainer = domElt.secondStepContainer;
		this.productsFoodTypes = domElt.productsFoodTypes;
		this.resultContainer = domElt.resultContainer;
		this.thirdStepContainer = domElt.thirdStepContainer;
		this.totalPriceElt = domElt.totalPriceElt;
		this.nextStepButton = domElt.nextStepButton;
		this.simulateButton = domElt.simulateButton;
		this.submitButton = domElt.submitButton;
		this.sendingButton = domElt.sendingButton;
		this.handleSimulator();
		this.handleEvents();
	}

	handleSimulator() {
		$(this.inputEmail).attr('placeholder', 'Votre adresse e-mail');
		$(this.secondStepContainer).hide();
		$(this.resultContainer).hide();
		$(this.thirdStepContainer).hide();
	}

	handleEvents() {
		let self = this;
		$(this.nextStepButton).click(function(e) {
			e.preventDefault();
			let isFirstStepDataValid = self.checkFirstStepData();

			if (isFirstStepDataValid) {
				$(self.secondStepContainer).fadeIn(500);
				self.disableNotMatchProducts();
			}
		});

		$(this.simulateButton).click(function(e) {
			e.preventDefault();
			let checkedInput = $(self.secondStepContainer).find('input:checked');
			let isFirstStepDataValid = self.checkFirstStepData();
			let isSecondStepDataValid = self.checkSecondStepData(checkedInput);

			if (isFirstStepDataValid && isSecondStepDataValid) {
				$(self.resultContainer).fadeIn(500);
				self.simulate(checkedInput);
			}
		});

		$(this.submitButton).click(function(e) {
			e.preventDefault();
			$(this).fadeOut('fast');
			$(self.thirdStepContainer).delay('fast').fadeIn();
		});

		$(this.sendingButton).click(function(e) {
			let isFirstStepDataValid = self.checkFirstStepData();
			let isThirdStepDataValid = self.checkThirdStepData();

			if (!isFirstStepDataValid || !isThirdStepDataValid) {
				e.preventDefault();
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

	checkThirdStepData() {
		let errorMessage = ' Merci de saisir une adresse e-mail valide.';
		let isValid = true;

		let email = $(this.inputEmail).val();
		let emailInputType = $(this.inputEmail).attr('type');
		if (!email || emailInputType !== 'email') {
			$(this.inputEmail).addClass('errorSimulator');
			this.addError(this.errorEmailElt, errorMessage);
			isValid = false;
		}
		else {
			this.removeError(this.errorEmailElt);
			$(this.inputEmail).removeClass('errorSimulator');
		}

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
		
		let errorMessage = ' Le ou les produits sélectionnés ne sont pas valides.';
		let self = this;
		$.ajax({
			type: 'POST',
			url: $(this.simulateButton).attr('data-url'),
			data: {
				nbChild: Number($(this.inputNbChild).val()),
				nbAdult: Number($(this.inputNbAdult).val()),
				foodType: $(this.selectedFoodTypeOption).text(),
				choices: choices
			},
			dataType: 'json',
		}).done(function(data) {
			let result = JSON.parse(data);
			if (result.isValid) {
				self.removeError(self.errorProductElt);
				$(self.totalPriceElt).text(result.totalPrice);
			}
			else {
				$(self.resultContainer).hide();
				self.addError(self.errorProductElt, errorMessage);
			}
		});
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
		inputEmail: '#simulator_email',
		errorNbAdultElt: '#nbAdultError',
		errorNbChildElt: '#nbChildError',
		errorProductElt: '#productError',
		errorEmailElt: '#emailError',
		secondStepContainer: '#secondStep',
		productsFoodTypes: '.foodTypes',
		resultContainer: '#result',
		thirdStepContainer: '#thirdStep',
		totalPriceElt: '#totalPrice span',
		nextStepButton: '#nextStep',
		simulateButton: '#simulate',
		submitButton: '#submit button',
		sendingButton: '#send'
	}
	
	const simulator = new Simulator(domElt);
});