<?php defined('SYSPATH') or die('No direct script access.'); ?>
			<h2>Redigera inställningar</h2>
			<form action="" method="post" enctype="multipart/form-data">
			
				<h3>Personlig information</h3>
				<fieldset>
					<p>Personlig information är sådan information som kommer att vara synligt för andra medlemmar på Linda Carlstad</p>
					<label for="city">
						<span>Nuvarande stad</span>
						<?php echo Form::input('city', $user->city, array('id' => 'city', 'autocomplete' => 'off')); ?>
					</label>
					<label for="occupation">
						<span>Nuvarande syssla</span>
						<?php echo Form::input('occupation', $user->occupation, array('id' => 'occupation', 'autocomplete' => 'off')); ?>
					</label>
					<label for="birthday_year">
						<span>Födelsedag</span>
						<?php echo Form::select('birthday_year', $options['year'], date("Y", $user->birthday)); ?>
						<?php echo Form::select('birthday_month',$options['month'], date("m", $user->birthday)); ?>
						<?php echo Form::select('birthday_day', $options['day'], date("d", $user->birthday)); ?>
					</label>
				</fieldset>
		
				<h3>Bildinställningar</h3>
				<fieldset>
					<p>Om du väljer att byta bild kommer den bild du laddas upp automatiskt att klippas och dimensioneras till 69x69 pixlar.</p>
					<figure>
						<img src="/images/users/<?php echo $user->image; ?>.jpg" alt="Ett fel uppstod" />	
						<figcaption>
							<label for="image">
								<span>Byt bild</span>
								<input type="file" name="image" id="image" />
							</label>
						</figcaption>
					</figure>					
				</fieldset>
			
				<h3>Lösenordsinställningar</h3>
				<fieldset>
					<p>För att ändra ditt lösenord måste du först fylla i det lösenord du använde för att logga in, sedan det du vill byta till.</p>
					<label for="currentpassword">
						<span>Nuvarande lösenord</span>
						<input type="password" name="currentpassword" id="currentpassword" />
					</label>		
					<label for="password">
						<span>Nytt lösenord</span>
						<input type="text" name="password" id="password" />
					</label>
				</fieldset>
				<button type="submit" name="submit" value="submit">Spara ändringar</button>
			</form>