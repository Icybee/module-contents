document.body.addEvent('click:relay(#manager td.cell--is-home-excluded .trigger)', function(ev, el) {

	el.toggleClass('on')

	new Request.API({

		url: el.getParent('form').elements[ICanBoogie.Operation.DESTINATION].value + '/' + el.get('data-nid') + '/is-home-excluded',

		onFailure: function(response) {

			el.toggleClass('on')

		},

		onSuccess: function(response) {

			el.fireEvent('change', {})

		}

	})[el.hasClass('on') ? 'put' : 'delete']()

})