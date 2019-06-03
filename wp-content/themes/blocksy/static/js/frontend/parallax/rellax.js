// ------------------------------------------
// Rellax.js - v1.0.0
// Buttery smooth parallax library
// Copyright (c) 2016 Moe Amaya (@moeamaya)
// MIT license
//
// Thanks to Paraxify.js and Jaime Cabllero
// for parallax concepts
// ------------------------------------------

// Ahh a pure function, gets new transform value
// based on scrollPostion and speed
// Allow for decimal pixel values
const updatePosition = (percentage, speed) => speed * (100 * (1 - percentage))

export class Rellax {
	constructor() {
		this.blocks = []
		this.oldPosY = false

		this.intersectionObserver = new IntersectionObserver(entries => {
			entries.map(({ target: el, isIntersecting }) => {
				let block = this.blocks.filter(
					({ fitInsideContainer }) => fitInsideContainer === el
				)[0]

				block.isVisible = isIntersecting

				if (!block.isVisible) block.el.removeAttribute('style')
			})
		})

		window.addEventListener('resize', () => {
			this.oldPosY = false

			this.blocks = this.blocks.map(
				({
					el,
					speed,
					fitInsideContainer,
					isVisible,
					shouldSetHeightToIncrease
				}) =>
					createBlock(
						el,
						speed,
						fitInsideContainer,
						isVisible,
						shouldSetHeightToIncrease
					)
			)

			this.animate()
		})

		// Start the loop
		this.update()

		// The loop does nothing if the scrollPosition did not change
		// so call animate to make sure every element has their transforms
		this.animate()
	}

	addEl(
		el,
		speed,
		fitInsideContainer = null,
		shouldSetHeightToIncrease = true
	) {
		this.intersectionObserver.observe(fitInsideContainer)
		this.blocks.push(
			createBlock(
				el,
				speed,
				fitInsideContainer,
				false,
				shouldSetHeightToIncrease
			)
		)
	}

	update() {
		if (!this.oldPosY) {
			this.animate()
		}

		if (this.setPosition()) {
			this.animate()
		}

		requestAnimationFrame(this.update.bind(this))
	}

	setPosition() {
		if (this.blocks.length === 0) return false

		let old = this.oldPosY
		this.oldPosY = pageYOffset

		return old != pageYOffset
	}

	animate() {
		this.blocks.map(block => {
			if (!block.isVisible) return

			var percentage =
				(pageYOffset - block.top + window.innerHeight) /
				(block.height + window.innerHeight)

			// Subtracting initialize value, so element stays in same spot as HTML
			var position =
				updatePosition(percentage, block.speed) -
				updatePosition(0.5, block.speed)

			// Move that element
			block.el.style.transform = `translate3d(0, ${position}px, 0)`
		})
	}
}

// We want to cache the parallax blocks'
// values: base, top, height, speed
// el: is dom object, return: el cache values
function createBlock(
	el,
	speed,
	fitInsideContainer = null,
	isVisible = false,
	shouldSetHeightToIncrease = true
) {
	// Optional individual block speed as data attr, otherwise global speed
	// Check if has percentage attr, and limit speed to 5, else limit it to 10
	// The function is named clamp
	speed = speed <= -5 ? -5 : speed >= 5 ? 5 : speed

	// We need to guess the position the background will be, when the section
	// will reach the top of the viewport. This calculation will be based on the
	// speed for sure
	if (fitInsideContainer && shouldSetHeightToIncrease) {
		let heightWeWantToIncrease = 0

		if (speed > 0) {
			heightWeWantToIncrease = updatePosition(0.5, speed)
		} else {
			heightWeWantToIncrease =
				updatePosition(
					window.innerHeight /
						(fitInsideContainer.clientHeight + window.innerHeight),
					speed
				) - updatePosition(0.5, speed)
		}

		heightWeWantToIncrease = Math.abs(heightWeWantToIncrease) * 2

		el.parentNode.style.height = `calc(100% + ${heightWeWantToIncrease}px)`
	}

	// initializing at scrollY = 0 (top of browser)
	// ensures elements are positioned based on HTML layout.

	let { top } = fitInsideContainer.getBoundingClientRect()

	var blockTop = pageYOffset + top

	return {
		shouldSetHeightToIncrease,
		fitInsideContainer,
		el,
		top: blockTop,
		height: fitInsideContainer.clientHeight,
		speed,
		isVisible
	}
}
