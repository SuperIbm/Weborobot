Ext.define("Ext.locale.en.Infoblock.view.Panel",
	{
	override: "Infoblock.view.Panel",
	title: "Infoblocks"
	}
);

Ext.define("Ext.locale.en.Infoblock.view.InfoblockUpdateWindow",
	{
	override: "Infoblock.view.InfoblockUpdateWindow",
	title: "Update infoblock",

		fbar:
		[
			{
			text: "Update"
			},
			{
			text: "Reset"
			},
			{
			text: "Cancel"
			}
		]
	}
);

Ext.define("Ext.locale.en.Infoblock.view.InfoblockUpdateTab",
	{
	override: "Infoblock.view.InfoblockUpdateTab",

		items:
		[
			{
			title: "Data"
			},
			{
			title: "HTML"
			}
		]
	}
);

Ext.define("Ext.locale.en.Infoblock.view.InfoblockGrid",
	{
	override: "Infoblock.view.InfoblockGrid",

		columns:
		[
			{
			header: 'ID'
			},
			{
			header: 'Name'
			},
			{
			header: 'Status'
			}
		],
	buttonCreateText: "Create",
	buttonUpdateText: "Update",
	buttonDestroyText: "Delete"
	}
);

Ext.define("Ext.locale.en.Infoblock.view.InfoblockCreateWindow",
	{
	override: "Infoblock.view.InfoblockCreateWindow",
	title: "Create infoblock",

		fbar:
		[
			{
			text: "Create"
			},
			{
			text: "Reset"
			},
			{
			text: "Cancel"
			}
		]
	}
);

Ext.define("Ext.locale.en.Infoblock.view.InfoblockCreateTab",
	{
	override: "Infoblock.view.InfoblockCreateTab",

		items:
		[
			{
			title: "Data"
			},
			{
			title: "HTML"
			}
		]
	}
);

Ext.define("Ext.locale.en.Infoblock.view.field.InfoblockLabelInfoblockText",
	{
	override: "Infoblock.view.field.InfoblockLabelInfoblockText",

	fieldLabel: "Name:<span class='needsForm'>*</span>",
	msgError: "The field have to contain the string from 1 to 255 length!"
	}
);

Ext.define("Ext.locale.en.Infoblock.store.Infoblock",
	{
	override: "Infoblock.store.Infoblock",

	error: "Error!",
	msgError: "The server error!"
	}
);

Ext.define("Ext.locale.en.Infoblock.controller.Infoblock",
	{
	override: "Infoblock.controller.Infoblock",

	maskLoad: "Loading...",

	error: "Error!",
	errorMsgServer: "The server error!",

	questionDestroyTitle: "Delete",
	questionDestroyMsg: "Do you want to delete these records?"
	}
);

Ext.define("Ext.locale.en.Infoblock.controller.InfoblockCreate",
	{
	override: "Infoblock.controller.InfoblockCreate",

	maskLoad: "Loading...",

	error: "Error!",
	errorMsgServer: "The server error!",

	warningNoCorrectTitle: "Warning!",
	warningNoCorrectMessage: "Pleas check, some fields in form are contained uncorrect data!",

	okTitle: "Created!",
	okMsg: "The data is created",

	errorMsgIsExist: "You can't create the infoblock because is exist."
	}
);

Ext.define("Ext.locale.en.Infoblock.controller.InfoblockUpdate",
	{
	override: "Infoblock.controller.InfoblockUpdate",

	maskLoad: "Loading...",

	error: "Error!",
	errorMsgServer: "The server error!",

	warningNoCorrectTitle: "Warning!",
	warningNoCorrectMessage: "Pleas check, some fields in form are contained uncorrect data!",

	okTitle: "Updated!",
	okMsg: "The data is Updated!",

	errorMsgIsExist: "You can't create the infoblock because is exist!"
	}
);

Ext.define("Ext.locale.en.Infoblock.controller.InfoblockUpdate",
	{
		override: "Infoblock.controller.InfoblockUpdate",

		maskLoad: "Loading...",

		error: "Error!",
		errorMsgServer: "The server error!",

		warningNoCorrectTitle: "Warning!",
		warningNoCorrectMessage: "Pleas check, some fields in form are contained uncorrect data!",

		okTitle: "Updated!",
		okMsg: "The data is Updated!",

		errorMsgIsExist: "You can't create the infoblock because is exist!"
	}
);