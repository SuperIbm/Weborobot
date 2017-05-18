Ext.define("Admin.view.ux.GridFilters",
	{
	extend: "Ext.grid.filters.Filters",
	
	alias: 'plugin.gridfiltersfixed',
	pluginId: 'gridfiltersfixed',

		init: function(grid)
		{
		var me = this,
		store, headerCt;

		me.grid = grid;
		grid.filters = me;

			if(me.grid.normalGrid)
			{
			me.isLocked = true;
			}

		grid.clearFilters = me.clearFilters.bind(me);

		store = grid.store;
		headerCt = grid.headerCt;

			headerCt.on
			(
				{
				scope: me,
				add: me.onAdd,
				menucreate: me.onMenuCreate
				}
			);

			grid.on
			(
				{
				scope: me,
				reconfigure: me.onReconfigure
				}
			);

		me.bindStore(store);

			if(grid.stateful)
			{
			store.statefulFilters = true;
			}

		me.initColumns(true);
		},

		initColumns: function (initializing)
		{
		var grid = this.grid,
		store = grid.getStore(),
		columns = grid.columnManager.getColumns(),
		len = columns.length,
		i, column,
		filter, filterCollection,
		blockLoad = initializing && !store.autoLoad && !grid.autoLoad;

			if(blockLoad && store.blockLoad)
			{
			store.blockLoad();
			}

			// We start with filters defined on any columns.
			for (i = 0; i < len; i++)
			{
			column = columns[i];
			filter = column.filter;

				if (filter && !filter.isGridFilter)
				{
					if(!filterCollection)
					{
					filterCollection = store.getFilters();
					filterCollection.beginUpdate();
					}

				this.createColumnFilter(column);
				}
			}

			if(filterCollection)
			{
			filterCollection.endUpdate();
			}

			if(blockLoad && store.unblockLoad)
			{
			store.unblockLoad(false);
			}
		}
	}
);