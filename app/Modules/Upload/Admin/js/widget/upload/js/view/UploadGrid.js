Ext.define('Upload.widget.upload.view.UploadGrid', 
	{
    extend: 'Upload.view.UploadGrid',
	alias: 'widget.Upload.widget.upload.view.UploadGrid',
	
	border: false,
	
		requires:
		[
		"Upload.view.UploadGrid"
		],
		
		dockedItems:
		[
			{
			xtype: 'pagingtoolbar',
			store: 'Upload',
			dock: 'bottom',
			displayInfo: false
			}
		],
		
		columns:
		[
			{
			header: 'ID',
			dataIndex: 'idModule',
			width: "10%",
			filter: 'number'
			},
			{
			header: 'Компонент',
			dataIndex: 'labelComponent',
			width: "30%",
			filter: 'string'
			},
			{
			header: 'Текущая версия',
			dataIndex: 'currentVersion',
			width: "30%",
				renderer : function(value, row, rowIndex, colIndex, store, view, ret)
				{				
					if(value) return value + " / " + row.record.getData()["currentDate"];
					else return "";
				}
			},
			{
			header: 'Следующая версия',
			dataIndex: 'nextVersion',
			width: "30%",
				renderer : function(value, row, rowIndex, colIndex, store, view, ret)
				{
					if(value) return value + " / " + row.record.getData()["nextDate"];
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
			hidden: Admin.getApplication().Access.is("Upload", "isUpdate") == true ? false : true
			};
		
			this.buttonUpdate = 
			{
			text: "Установить обновление",
			iconCls: "icon_button_set",
			action: "set",
			hidden: Admin.getApplication().Access.is("Upload", "isUpdate") == true ? false : true
			};
		
		this.callParent();	
		}
	}
);