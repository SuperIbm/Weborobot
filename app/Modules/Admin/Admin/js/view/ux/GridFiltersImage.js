Ext.define('Admin.view.ux.GridFiltersImage',
	{
	extend: 'Ext.grid.filters.filter.SingleFilter',
	alias: 'grid.filter.image',

	type: 'image',

	operator: 'empty',

	/**
	 * @cfg {Boolean} defaultValue
	 * Set this to null if you do not want either option to be checked by default. Defaults to false.
	 */
	defaultValue: false,

	//<locale>
	/**
	 * @cfg {String} yesText
	 * Defaults to 'Yes'.
	 */
	yesText: 'Yes',
	//</locale>

	//<locale>
	/**
	 * @cfg {String} noText
	 * Defaults to 'No'.
	 */
	noText: 'No',
	//</locale>

	updateBuffer: 0,

	/**
	 * @private
	 * Template method that is to initialize the filter and install required menu items.
	 */
	createMenu: function(config)
	{
	var me = this,
	gId = Ext.id(),
		listeners =
		{
		scope: me,
		click: me.onClick
		},
	itemDefaults = me.getItemDefaults();

	me.callParent(arguments);

		me.menu.add
		(
			[
				Ext.apply
				(
					{
					text: me.yesText,
					filterKey: 0,
					group: gId,
					checked: !!me.defaultValue,
					listeners: listeners
					},
				itemDefaults
				),
				Ext.apply
				(
					{
					text: me.noText,
					filterKey: 1,
					group: gId,
					checked: !me.defaultValue,
					listeners: listeners
					},
				itemDefaults
				)
			]
		);
	},

	/**
	 * @private
	 */
	onClick: function(field)
	{
	this.setValue(!!field.filterKey);
	},

	/**
	 * @private
	 * Template method that is to set the value of the filter.
	 * @param {Object} value The value to set the filter.
	 */
	setValue: function(value)
	{
	var me = this;
	me.filter.setValue(value);

		if(value !== undefined && me.active)
		{
		me.value = value;
		me.updateStoreFilter();
		}
		else
		{
		me.setActive(true);
		}
	},

	// This is supposed to be just a stub.
	activateMenu: Ext.emptyFn
});