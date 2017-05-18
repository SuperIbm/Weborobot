Ext.define('Upload.view.UploadGrid', 
	{
    extend: 'Admin.view.ux.GridPanel',
	alias: 'widget.Upload.view.UploadGrid',
	
	name: "Upload",
	store: 'Upload',
	multiColumnEdit: true,
	
		dockedItems:
		[
			{
			xtype: 'pagingtoolbar',
			store: 'Upload',
			dock: 'bottom',
			displayInfo: true
			}
		],
	
		columns:
		[
			{
			header: 'ID',
			dataIndex: 'idUpload',
			width: "5%",
			filter: 'number'
			},
			{
			header: 'Модуль',
			dataIndex: 'labelModule',
			width: "35%",
			filter: 'string'
			},
			{
			header: 'Текущая версия',
			dataIndex: 'currentVersion',
			width: "30%",
			sortable: false,
				renderer : function(value, row, rowIndex, colIndex, store, view, ret)
				{
					if(value) return "<b>" + value + "</b> / " + Ext.Date.format(row.record.getData()["currentDate"], "j F Y");
					else return "";
				}
			},
			{
			header: 'Следующая версия',
			dataIndex: 'nextVersion',
			width: "30%",
			sortable: false,
				renderer : function(value, row, rowIndex, colIndex, store, view, ret)
				{
					if(value) return "<b>" + value + "</b> / " + Ext.Date.format(row.record.getData()["nextDate"], "j F Y");
					else return "";
				}
			}
		],
		initComponent: function()
		{
			this.buttonCreate = 
			{
			text: "Проверить обновление",
			iconCls: "icon_button_check",
			action: "check",
			hidden: !Admin.getApplication().Access.is("Upload", "isUpdate")
			};
			
			this.buttonUpdate = 
			{
			text: "Установить обновление",
			iconCls: "icon_button_set",
			action: "set",
			hidden: !Admin.getApplication().Access.is("Upload", "isUpdate")
			};
		
		this.callParent();	
		}
	}
);