/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(function () {
  // Summernote
  $('#articles-description').summernote({
     toolbar: [
                  ['style', ['bold', 'italic', 'underline', 'clear']]
                ],
        placeholder: 'Write article description here maximal 165 characters ...',
        callbacks: {
            onKeydown: function (e) { 
                var t = e.currentTarget.innerText; 
                if (t.trim().length >= 165) {
                    //delete keys, arrow keys, copy, cut, select all
                    if (e.keyCode != 8 && !(e.keyCode >=37 && e.keyCode <=40) && e.keyCode != 46 && !(e.keyCode == 88 && e.ctrlKey) && !(e.keyCode == 67 && e.ctrlKey) && !(e.keyCode == 65 && e.ctrlKey))
                    e.preventDefault(); 
                } 
            },
            onKeyup: function (e) {
                var t = e.currentTarget.innerText;
                $('#maxContentPost').text(165 - t.trim().length);
            },
            onPaste: function (e) {
                var t = e.currentTarget.innerText;
                var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
                e.preventDefault();
                var maxPaste = bufferText.length;
                if(t.length + bufferText.length > 165){
                    maxPaste = 165 - t.length;
                }
                if(maxPaste > 0){
                    document.execCommand('insertText', false, bufferText.substring(0, maxPaste));
                }
                $('#maxContentPost').text(165 - t.length);
            }
        }
    });
  $('#summernote_employee').summernote({
     toolbar: [
                  ['style', ['bold', 'italic', 'underline', 'clear']]
                ],
        placeholder: 'Describe about you here maximal 165 characters ...',
        callbacks: {
            onKeydown: function (e) { 
                var t = e.currentTarget.innerText; 
                if (t.trim().length >= 165) {
                    //delete keys, arrow keys, copy, cut, select all
                    if (e.keyCode != 8 && !(e.keyCode >=37 && e.keyCode <=40) && e.keyCode != 46 && !(e.keyCode == 88 && e.ctrlKey) && !(e.keyCode == 67 && e.ctrlKey) && !(e.keyCode == 65 && e.ctrlKey))
                    e.preventDefault(); 
                } 
            },
            onKeyup: function (e) {
                var t = e.currentTarget.innerText;
                $('#maxContentPost').text(165 - t.trim().length);
            },
            onPaste: function (e) {
                var t = e.currentTarget.innerText;
                var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
                e.preventDefault();
                var maxPaste = bufferText.length;
                if(t.length + bufferText.length > 165){
                    maxPaste = 165 - t.length;
                }
                if(maxPaste > 0){
                    document.execCommand('insertText', false, bufferText.substring(0, maxPaste));
                }
                $('#maxContentPost').text(165 - t.length);
            }
        }
    });
    $('#medias-description').summernote({
     toolbar: [
                  ['style', ['bold', 'italic', 'underline', 'clear']]
                ],
        placeholder: 'Write image description here maximal 165 characters ...',
        callbacks: {
            onKeydown: function (e) { 
                var t = e.currentTarget.innerText; 
                if (t.trim().length >= 165) {
                    //delete keys, arrow keys, copy, cut, select all
                    if (e.keyCode != 8 && !(e.keyCode >=37 && e.keyCode <=40) && e.keyCode != 46 && !(e.keyCode == 88 && e.ctrlKey) && !(e.keyCode == 67 && e.ctrlKey) && !(e.keyCode == 65 && e.ctrlKey))
                    e.preventDefault(); 
                } 
            },
            onKeyup: function (e) {
                var t = e.currentTarget.innerText;
                $('#maxContentPost').text(165 - t.trim().length);
            },
            onPaste: function (e) {
                var t = e.currentTarget.innerText;
                var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
                e.preventDefault();
                var maxPaste = bufferText.length;
                if(t.length + bufferText.length > 165){
                    maxPaste = 165 - t.length;
                }
                if(maxPaste > 0){
                    document.execCommand('insertText', false, bufferText.substring(0, maxPaste));
                }
                $('#maxContentPost').text(165 - t.length);
            }
        }
    });
    $('#articles-article').summernote({
        placeholder: 'Write article here ...',
    });
});
