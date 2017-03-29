<div>
   <div class="table-responsive">
		<table class="table table-striped">
			
			<thead>							
				<tr>
					<th>Company</th>
					<th>Quota</th>
					<th>Edit</th>
					<th>Delete</th>
				</tr>
			</thead>
			
		   <tbody>	
				<?php
					foreach ($compLink as $val) {
						$strPrint = '<tr> ';
							$strPrint .= 	'<td style="display:none" >' . $val["IdCompany"] . '</td>';
							$strPrint .= '<td>' . $val["CompanyName"] . '</td>';
							$strPrint .= 	'<td style="display:none" >' . $val["Quota"] . '</td>';
							$strPrint .= 	'<td>' . $val["QuotaTB"] . '</td>';
							$strPrint .=  '<td> <button type="button" class="btn btn-warning btn-edit-record">Edit</button> </td>';
							$strPrint .=  '<td> <button type="button" class="btn btn-danger btn-delete-record">Delete</button> </td>';
						$strPrint .= '</tr>';
						echo $strPrint;
					}
				?>
			</tbody>
		</table>
	</div>
				
	<div>
		<button type="button" class="btn btn-success btn-add-record">Add</button> 
	</div>

	<?php
		$this->_myPaginator->show();
	?>				
</div>