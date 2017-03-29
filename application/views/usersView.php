<div>
   <div class="table-responsive">
      <table class="table table-striped">
			
			<thead>							
            <tr>
					<th>Name</th>
					<th>Email</th>
					<th>Company</th>
					<th>Edit</th>
					<th>Delete</th>
				</tr>
			</thead>
			
			<tbody>		 
				<?php
					foreach ($userLink as $val) {
						$strPrint = '<tr> ';
							$strPrint .= 	'<td style="display:none" >' . $val["IdUser"] . '</td>';
							$strPrint .= '<td>' . $val["Name"] . '</td>';
							$strPrint .= 	'<td>' . $val["Email"] . '</td>';
							$strPrint .= 	'<td>' . $val["CompanyName"] . '</td>';
							$strPrint .= 	'<td style="display:none">' . $val["IdCompany"] . '</td>';
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
				
 