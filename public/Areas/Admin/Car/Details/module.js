var app = angular.module('cars2let', ['angularMoment', 'angularModalService', 'angularFileUpload', 'ui.select', 'ngSanitize', 'ui.bootstrap']);
//app.config(function (dropzoneOpsProvider) {
//    dropzoneOpsProvider.setOptions({
//        url: '/upload_url',
//        paramName: 'photo',
//        maxFilesize: '10',
//        acceptedFiles: 'image/jpeg, images/jpg, image/png',
//        addRemoveLinks: true,
//        dictDefaultMessage : 'Click to add or drop photos',
//        dictRemoveFile : 'Remove photo',
//        dictResponseError : 'Could not upload this photo'
//    });
//});
//Add below line at the top of your JavaScript code
//Dropzone.autoDiscover = false;
//This will prevent Dropzone to instantiate on it's own unless you are using dropzone class for styling