Ext.define('Admin.view.ux.GridFiltersDocument',
	{
	extend: 'Admin.view.ux.GridFiltersImage',
	alias: 'grid.filter.document',

		requires:
		[
		'Admin.view.ux.GridFiltersImage'
		],

	type: 'document',
	operator: 'empty'
	}
);