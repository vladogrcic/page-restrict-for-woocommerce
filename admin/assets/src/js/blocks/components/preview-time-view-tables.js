function PreviewTimeViewTables(props) {
	const __ = wp.i18n.__;
	let table;
	let time_class = 'timeout_table time';
	if (props.disable_table_class) {
		time_class = '';
	}
	const time_table = (
		<table className={time_class}>
			<tbody>
				<tr>
					<th>{__('Page', 'page_restrict_domain')}</th>
					<th>{__('Time of Expiration', 'page_restrict_domain')}</th>
				</tr>
				<tr>
					<td>
						{__(
							'Sint quam voluptatem sed accusamus ut',
							'page_restrict_domain'
						)}
					</td>
					<td>{__('18.04.2020 19:11', 'page_restrict_domain')}</td>
				</tr>
				<tr>
					<td>
						{__(
							'Phasellus et fringilla velit',
							'page_restrict_domain'
						)}
					</td>
					<td>{__('08.04.2020 04:32', 'page_restrict_domain')}</td>
				</tr>
				<tr>
					<td>
						{__(
							'Animi maxime numquam veniam aliquam aut distinctio',
							'page_restrict_domain'
						)}
					</td>
					<td>{__('14.04.2020 19:11', 'page_restrict_domain')}</td>
				</tr>
			</tbody>
		</table>
	);
	let view_class = 'timeout_table view';
	if (props.disable_table_class) {
		view_class = '';
	}
	const view_table = (
		<table className={view_class}>
			<tbody>
				<tr>
					<th>{__('Page', 'page_restrict_domain')}</th>
					<th>{__('View', 'page_restrict_domain')}</th>
					<th>{__('Views left', 'page_restrict_domain')}</th>
				</tr>
				<tr>
					<td>
						{__(
							'Fugiat repellat qui harum minus recusandae',
							'page_restrict_domain'
						)}
					</td>
					<td>2</td>
					<td>4</td>
				</tr>
				<tr>
					<td>
						{__(
							'Doloremque non sunt sint dolorum',
							'page_restrict_domain'
						)}
					</td>
					<td>2</td>
					<td>3</td>
				</tr>
				<tr>
					<td>
						{__('Ut vel quibusdam totam', 'page_restrict_domain')}
					</td>
					<td>2</td>
					<td>3</td>
				</tr>
			</tbody>
		</table>
	);
	if (props.time) {
		table = time_table;
	}
	if (!(props.time && props.view)) {
		table = time_table;
	}
	if (props.view) {
		table = view_table;
	}
	return table;
}
export default PreviewTimeViewTables;
