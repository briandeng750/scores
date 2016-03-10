<?php

return [
		'propel' => [
				'database' => [
						'connections' => [
								'ezscore' => [
										'adapter'    => 'mysql',
										'classname'  => 'Propel\Runtime\Connection\ConnectionWrapper',
										'dsn'        => 'mysql:host=localhost;dbname=lccgden4_scores',
										'user'       => 'lccgden4_scores',
										'password'   => '@Xp&DiCf3NKq',
										'attributes' => []
								]
						]
				],
				'runtime' => [
						'defaultConnection' => 'ezscore',
						'connections' => ['ezscore']
				],
				'generator' => [
						'defaultConnection' => 'ezscore',
						'connections' => ['ezscore']
				]
		]
];
