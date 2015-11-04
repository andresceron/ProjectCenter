		<footer class="footer">
			<p class="text-center">Copyright &copy; 2015 | Andres Ceron</p>
		</footer>
	</body>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?= $variables->getAssetsJS(); ?>/main.js"></script>
	<script src="../../assets/js/jquery.bootstrap.wizard.min.js"></script>
	<script>
	$(document).ready(function() {				
		$('#inverse').bootstrapWizard({'tabClass': 'nav', 'debug': false, onShow: function(tab, navigation, index) {
			console.log('onShow');
		}, onNext: function(tab, navigation, index) {
			console.log('onNext');
			if(index==2) {
				// Make sure we entered the name
				if(!$('#name').val()) {
					alert('You must enter your name');
					$('#name').focus();
					return false;
				}
			}			
		// Set the name for the next tab
		$('#inverse-tab3').html('Hello, ' + $('#name').val());				
			}, onPrevious: function(tab, navigation, index) {
				console.log('onPrevious');
			}, onLast: function(tab, navigation, index) {
				console.log('onLast');
			}, onTabClick: function(tab, navigation, index) {
				console.log('onTabClick');
				alert('on tab click disabled');
				return false;
			}, onTabShow: function(tab, navigation, index) {
				console.log('onTabShow');
				var $total = navigation.find('li').length;
				var $current = index+1;
				var $percent = ($current/$total) * 100;
				$('#inverse').find('.bar').css({width:$percent+'%'});
			}});
		$('#tabsleft .finish').click(function() {
			alert('Finished!, Starting over!');
			$('#tabsleft').find("a[href*='tabsleft-tab1']").trigger('click');
		});	
	});
	</script>
</html> 