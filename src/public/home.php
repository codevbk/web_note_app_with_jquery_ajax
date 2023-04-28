<?php
if($ajax == false){
?>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Web Note App</title>
<?php
$i = 0;
while(isset(ASSETS_ONLINE_CSS[$i])){
    if(ONLINE == true){
        ?>
        <link rel="stylesheet" type="text/css" href="<?php echo ASSETS_ONLINE_CSS[$i]; ?>">
        <?php
    }else{
        ?>
        <link rel="stylesheet" type="text/css" href="<?php echo $urlHost.ASSETS_CSS."/".ASSETS_OFFLINE_CSS[$i]; ?>">
        <?php
    }
    ++$i;
}
?>
</head>
<body>
<?php
include DOCUMENT_PUBLIC."/list.php";
?>
<?php
$i = 0;
while(isset(ASSETS_ONLINE_JS[$i])){
    if(ONLINE == true){
        ?>
        <script src="<?php echo ASSETS_ONLINE_JS[$i]; ?>"></script>
        <?php
    }else{
        ?>
        <script src="<?php echo $urlHost.ASSETS_JS."/".ASSETS_OFFLINE_JS[$i]; ?>"></script>
        <?php
    }
    ++$i;
}
?>
<script>
function datetime_now(){
    var date = new Date();
	var dateStr =
	date.getFullYear() + "-" +("00" + (date.getMonth() + 1)).slice(-2) + "-" +("00" + date.getDate()).slice(-2) + " " +
	("00" + date.getHours()).slice(-2) + ":" +
	("00" + date.getMinutes()).slice(-2) + ":" +
	("00" + date.getSeconds()).slice(-2);
	return dateStr;
}

// Prototype Class
class NoteInterfacePrototype {
  clone() {}
}

// Concrete Prototype Singleton Class
class NotePrototype extends NoteInterfacePrototype{
  constructor(noteModel, noteView, noteController) {
    if (NotePrototype.instance instanceof NotePrototype) {
      return NotePrototype.instance;
    }
	super();
    this.noteModel = noteModel;
    this.noteView = noteView;
    this.noteController = noteController;
    NotePrototype.instance = this;
  }

  clone() {
    var clonedModel = Object.create(this.noteModel);
    var clonedView = Object.create(this.noteView);
    var clonedController = Object.create(this.noteController);
    return new NotePrototype(clonedModel, clonedView, clonedController);
  }
}

// Abstract Factory (Builder Interface)
class NoteAbstractFactory {
	createModel() {}
	createView(model) {}
	createController(model, view) {}
}

// Concrete Factory Method (Builder)
class NoteFactory extends NoteAbstractFactory {
	createModel() {
		return new NoteModel();
	}

	createView(model) {
		return new NoteView(model);
	}

	createController(model, view) {
		return new NoteController(model, view);
	}
}

// Director Class
class NoteFactoryDirector {
	constructor(builder) {
		this.builder = builder;
	}

	construct() {
		var noteModel = this.builder.createModel();
		var noteView = this.builder.createView(noteModel);
		var noteController = this.builder.createController(noteModel, noteView);
		return {
		model: noteModel,
		view: noteView,
		controller: noteController
		};
	}
}

// Model
class NoteModel {
	constructor() {
        this.NoteID = 1;
		this.NoteList = [];
	}

	addNoteItem(noteID,noteTitle,noteContent) {
		var noteObject = {
			id: this.NoteID,
			title: noteTitle,
			content: noteContent
		};
        $.ajax({
			context: this,
			type: "POST",
			url: "?action=create",
			async: false,
			data: JSON.stringify(noteObject),
			success: function(response){
				this.NoteList.push(noteObject);
        		this.NoteID++;

			},
			error: function(error){
				console.error("Error : ", error);
			}
		});
	}

	editNoteItem(noteID, noteTitle, noteContent) {
		for (var i = 0; i < this.NoteList.length; i++) {
			if (this.NoteList[i]["id"] == noteID) {
				this.NoteList[i]["title"] = noteTitle;
    			this.NoteList[i]["content"] = noteContent;
			}
		}
  	}

	deleteNoteItem(noteID) {
		for (var i = 0; i < this.NoteList.length; i++) {
			if (this.NoteList[i]["id"] == noteID) {
				this.NoteList.splice(i, 1);
				break;
			}
		}
	}

	getNoteList() {
		return this.NoteList;
	}
}

//View
class NoteView {
	constructor(noteModel) {
		this.noteModel = noteModel;
		this.noteListElement = $("#note_list");
		this.noteContentElement = $("#note_edit_content");
		this.noteEditTitleElement = $("#note_edit_title");
		this.noteEditElement = $("#note_edit");
		this.noteSaveElement = $("#note_save");
	}

	renderNoteList() {
		this.noteListElement.empty();
		var noteList = this.noteModel.getNoteList();
        if(noteList.length > 0){
            for (var i = 0; i < noteList.length; i++) {
                this.noteListElement.append(
                    '<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-4" data-id="'+noteList[i]["id"]+'">\
                        <div class="card">\
                        <div class="card-header">\
                            Note :\
                        </div>\
                        <div class="card-body">\
                            <h5 class="card-title">Note : <span id="note_title"> ' +noteList[i]["title"]+'</span></h5>\
                            <p class="card-text" id="note_content">'+noteList[i]["content"]+'</p>\
                            <a href="javascript:;" class="btn btn-primary" id="note_edit"><i class="bi bi-pencil-square"></i></a>\
							<a href="javascript:;" class="btn btn-primary" id="note_delete"><i class="bi bi-trash"></i></a>\
                        </div>\
                        </div>\
                    </div>'
                );
		    }
        }

	}

	getNoteContentValue() {
		return this.noteContentElement.val();
	}

	getNoteIDValue() {
		return this.noteContentElement.parent().parent().attr("data-id");
	}

	setNoteTitleValue(value) {
		return this.noteEditTitleElement.text(value);
	}

	setNoteContentValue(value) {
		return this.noteContentElement.val(value);
	}

	setNoteIDValue(value) {
		return this.noteContentElement.parent().parent().attr("data-id",value);
	}

	clearNoteInput() {
		this.noteContentElement.val("");
		this.noteEditTitleElement.text("");
		this.noteContentElement.parent().parent().attr("data-id", "");
	}

	addNoteItemHandler(callback) {
		this.noteSaveElement.click(callback);
	}

	editNoteItemHandler(callback) {
		this.noteListElement.on("click", "#note_edit", function(event) {
			var noteElement = $(this).parent().parent().parent();
			var noteID = $(noteElement).attr("data-id");
			callback(noteID);
		});
	}

	deleteNoteItemHandler(callback) {
		this.noteListElement.on("click", "#note_delete", function(event) {
			var noteElement = $(this).parent().parent().parent();
			var noteID = $(noteElement).attr("data-id");
			callback(noteID);
		});
	}

	addNoteItemEnterHandler(callback) {
		this.noteContentElement.keypress(function(event) {
			if (event.which == 13) {
				callback();
			}
		});
	}
}

// Controller
class NoteController {
	constructor(noteModel, noteView) {
		this.noteModel = noteModel;
		this.noteView = noteView;
		this.noteView.addNoteItemHandler(this.addNoteItem.bind(this));
		this.noteView.editNoteItemHandler(this.editNoteItem.bind(this));
		this.noteView.deleteNoteItemHandler(this.deleteNoteItem.bind(this));
		this.noteView.addNoteItemEnterHandler(this.addNoteItem.bind(this));
		this.renderNoteList();
	}

	renderNoteList() {
		this.noteView.renderNoteList();
	}

	addNoteItem() {
		var noteContent = this.noteView.getNoteContentValue();
		var noteID = this.noteView.getNoteIDValue();
        if(noteContent !== ''){
			if(noteID !== ''){
				this.noteModel.editNoteItem(noteID,datetime_now(),noteContent);
			}else{
				this.noteModel.addNoteItem(null,datetime_now(),noteContent);
			}
            this.renderNoteList();
		    this.noteView.clearNoteInput();
        }else{
            alert("Please fill required inputs");
        }
	}

	editNoteItem(noteID) {
		this.noteView.setNoteIDValue(noteID);
		for (var i = 0; i < this.noteModel.getNoteList().length; i++) {
			if (this.noteModel.getNoteList()[i]["id"] == noteID) {
				this.noteView.setNoteTitleValue(this.noteModel.getNoteList()[i]["title"]);
				this.noteView.setNoteContentValue(this.noteModel.getNoteList()[i]["content"]);
			}
		}

		this.renderNoteList();
	}

	deleteNoteItem(noteID) {
		this.noteModel.deleteNoteItem(noteID);
		this.renderNoteList();
	}
}

var noteFactory = new NoteFactory();
var noteFactoryDirector = new NoteFactoryDirector(noteFactory);
var note = noteFactoryDirector.construct();

// Singleton Prototype Class
var notePrototype = new NotePrototype(
note.model,
note.view,
note.controller
);

// Cloning Prototype
var clonedNotePrototype = notePrototype.clone();
</script>
</body>
</html>
<?php
}
?>