class Simulator {
	constructor(domElt) {
		this.inputNbAdult = domElt.inputNbAdult;
		this.inputNbChild = domElt.inputNbChild;
		this.selectedFoodTypes = domElt.selectedFoodTypes;
		this.selectedFoodTypeOption = domElt.selectedFoodTypeOption;
		this.inputEmail = domElt.inputEmail;
		this.errorNbAdultElt = domElt.errorNbAdultElt;
		this.errorNbChildElt = domElt.errorNbChildElt;
		this.errorFoodTypeElt = domElt.errorFoodTypeElt;
		this.errorProductElt = domElt.errorProductElt;
		this.errorEmailElt = domElt.errorEmailElt;
		this.noContractElt = domElt.noContractElt;
		this.secondStepContainer = domElt.secondStepContainer;
		this.contractElt= domElt.contractElt;
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
		$('select').select2({
		    placeholder: "Sélectionnez un ou plusieurs type d'alimentation"
		});
		$(this.inputEmail).attr('placeholder', 'Votre adresse e-mail');
		$(this.noContractElt).hide();
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
		let selectedFoodTypes = [];
		$(this.selectedFoodTypeOption).each(function(){
			selectedFoodTypes.push($(this).text());
		});
		
		let nbContracts = $(this.contractElt).length;
		let self = this;
		$(this.contractElt).each(function() {
			$(this).show();
			let $foodTypes = $(this).find(self.productsFoodTypes);
			let nbProducts = $foodTypes.length;
			$foodTypes.hide();

			$foodTypes.each(function() {
				$(this).parent().show();

				let isMatched = false;
				$(this).children('span').each(function() {
					let presence = $.inArray($(this).text(), selectedFoodTypes);
					if (presence > -1) {
						isMatched = true;
					}
				});

				if (isMatched === false) {
					$(this).parent().hide();
					nbProducts--;
				}
			});

			if (nbProducts === 0) {
				$(this).hide();
				nbContracts--;
			}
		});

		if (nbContracts === 0) {
			$(this.noContractElt).fadeIn(500);
		}
		else {
			$(this.noContractElt).hide();
		}
	}

	simulate(checkedInput) {
		let selectedFoodTypes = [];
		$(this.selectedFoodTypeOption).each(function(){
			selectedFoodTypes.push($(this).val());
		});

		let choices = [];
		$(checkedInput).each(function() {
			if ($(this).is(':visible')) {
				choices.push($(this).val());
			}
		});

		let foodTypesErrorMessage = ' Le ou les types d\'alimentation sélectionnés ne sont pas valides.';
		let productsErrorMessage = ' Le ou les produits sélectionnés ne sont pas valides.';
		let self = this;
		$.ajax({
			type: 'POST',
			url: $(this.simulateButton).attr('data-url'),
			data: {
				nbChild: Number($(this.inputNbChild).val()),
				nbAdult: Number($(this.inputNbAdult).val()),
				selectedFoodTypes: selectedFoodTypes,
				choices: choices
			},
			dataType: 'json',
		}).done(function(data) {
			let result = JSON.parse(data);
			if (result.isFoodTypesValid && result.isProductsValid) {
				$(this.selectedFoodTypes).removeClass('errorSimulator');
				self.removeError(self.errorFoodTypeElt);
				self.removeError(self.errorProductElt);
				$(self.totalPriceElt).text(result.totalPrice);
			}
			else {
				$(self.resultContainer).hide();

				if (!result.isFoodTypesValid) {
					$(this.selectedFoodTypes).addClass('errorSimulator');
					self.addError(self.errorFoodTypeElt, foodTypesErrorMessage);
				}

				if (!result.isProductsValid) {
					self.addError(self.errorProductElt, productsErrorMessage);
				}
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
		selectedFoodTypes: '#simulator_food_type',
		selectedFoodTypeOption: '#simulator_food_type option:selected',
		inputEmail: '#simulator_email',
		errorNbAdultElt: '#nbAdultError',
		errorNbChildElt: '#nbChildError',
		errorFoodTypeElt: '#foodTypeError',
		errorProductElt: '#productError',
		errorEmailElt: '#emailError',
		noContractElt: '#noContract',
		secondStepContainer: '#secondStep',
		contractElt: '.contract',
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