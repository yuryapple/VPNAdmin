	<div>
		<div class="table-responsive">
			<table class="table table-striped">
				
				<thead>							
					<tr>
						<th>Company</th>
						<th>Quota</th>
						<th>Total transferred</th>
						<th>Abuse</th>
					</tr>
				</thead>
				
				<tbody>		 
					<?php
						foreach ($abuseLink as $val) {
							$strPrint = '<tr> ';
								$strPrint .= '<td>' . $val["CompanyName"] . '</td>';
								$strPrint .= 	'<td>' . $val["Quota"] . '</td>';
								$strPrint .= 	'<td>' . $val["TotalTransferred"] . '</td>';
								$strPrint .= 	'<td class="text-warning">' . $val["Abuse"] . '</td>';
							$strPrint .= '</tr>';
							echo $strPrint;
						}
					?>
				</tbody>
			</table>
		</div>
	</div>