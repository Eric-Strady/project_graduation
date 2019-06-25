<?php

namespace App\Simulator;

use App\Entity\Product;

class CalculatePrice
{
	const CHILD = 0.5;
	const ADULT = 1;
	const SMALL_FAMILY = 2.5;
	const LARGE_FAMILY = 5;

	private $nbChild;
	private $nbAdult;
	private $isVariableDelivery;
    private $nbDelivery;
    private $isFixedPrice;
    private $fixedPrice;
    private $minPrice;
    private $maxPrice;

	private $familyIndex;
	private $multiplicator;
	private $price;

    public function definePrice($nbChild, $nbAdult, Product $product) {
    	$this->nbChild = $nbChild;
    	$this->nbAdult = $nbAdult;
    	$this->isVariableDelivery = $product->getIsVariableDelivery();
    	$this->nbDelivery = $product->getNbDelivery();
    	$this->isFixedPrice = $product->getIsFixedPrice();
    	$this->fixedPrice = $product->getFixedPrice();
    	$this->minPrice = $product->getMinPrice();
    	$this->maxPrice = $product->getMaxPrice();

    	$this->setFamilyIndex();
    	$this->setMultiplicator();
    	$this->setPrice();

    	return round($this->price);
    }

    private function setFamilyIndex() {
    	$childIndex = $this->nbChild * self::CHILD;
    	$adultIndex = $this->nbAdult * self::ADULT;

    	$this->familyIndex = $childIndex + $adultIndex;
    }

    private function setMultiplicator() {
    	if ($this->isVariableDelivery) {
			if ($this->nbDelivery) {
				$this->multiplicator = $this->nbDelivery;
			}
		}
		else {
			$this->multiplicator = 1;
		}
    }

    private function setPrice() {
    	if ($this->familyIndex > 0 && $this->familyIndex <= self::SMALL_FAMILY) {
    		$this->calculInRange(self::SMALL_FAMILY, null);
    	}
    	elseif ($this->familyIndex > self::SMALL_FAMILY && $this->familyIndex <= self::LARGE_FAMILY) {
    		$this->calculInRange(self::LARGE_FAMILY, null);
    	}
    	elseif ($this->familyIndex > self::LARGE_FAMILY) {
    		$this->calculOutRange(self::LARGE_FAMILY);
    	}
    }

    private function calculInRange($familyType, $quotientDown) {
		if ($this->isFixedPrice) {
			if ($this->fixedPrice) {
				switch ($familyType) {
					case self::SMALL_FAMILY:
						$this->price += ($this->fixedPrice / 2) * $this->multiplicator;
						break;
					
					default:
						if ($quotientDown !== null) {
							$this->price += ($this->fixedPrice * $quotientDown) * $this->multiplicator;
						}
						else {
							$this->price += $this->fixedPrice * $this->multiplicator;
						}
						break;
				}
			}
		}
		else {
			switch ($familyType) {
				case self::SMALL_FAMILY:
					$this->price += $this->minPrice * $this->multiplicator;
					break;
				
				default:
					if ($quotientDown !== null) {
							$this->price += ($this->maxPrice * $quotientDown) * $this->multiplicator;
					}
					else {
						$this->price += $this->maxPrice * $this->multiplicator;
					}
					break;
			}
		}
	}

	private function calculOutRange($familyType) {
		$quotientDown = floor($this->familyIndex / $familyType);
		$familyIndexWithQuotient = $familyType * $quotientDown;
		$remainder = $this->familyIndex - $familyIndexWithQuotient;

		switch ($remainder) {
			case 0:
				$this->calculInRange($familyType, $quotientDown);
				break;
			
			default:
				$this->calculInRange($familyType, $quotientDown);
				$this->familyIndex = $remainder;
				$this->setPrice();
				break;
		}
	}
}