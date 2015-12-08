define({
    init: function(listObj, selectObj, buttonObj, tbodyObj) {
      this.list = listObj;
      this.button = buttonObj;
      this.tbody = tbodyObj;
      this.select = selectObj;

      this.self = this;
      this.initHooks();
    },

    addToList: function(id) {
      var list = this.list.val().split(',');
      list.push(id);
      this.list.val(list.join(','));
    },

    removeFromList: function(id) {
      var list = this.list.val().split(',');
      var index = list.indexOf(id.toString());
      if (index >= 0) {
        list.remove(id.toString());
      }

      this.list.val(list.join(','));
    },

    isInList: function(id) {
      var list = this.list.val().split(',');
      var index = list.indexOf(id.toString());

      return (index >= 0);
    },

    initHooks: function() {
      var self = this;

      this.button.click(function(e) {
        e.preventDefault();
        var id = self.select.val();
        var name = $('#'+self.select.attr('id')+' option:selected').text();

        if (self.isInList(id) == false) {
          self.tbody.append(
            '<tr id="row'+id+'"><td>'+name+'</td>'
            +'<td><a href="#" class="remove" id="'+id+'">X</a></td></tr>'
          );
          self.addToList(id);
        }
      });

      this.tbody.on('click', 'a.remove', function(e) {
        e.preventDefault();
        var id = $(e.target).attr('id');
        $('#'+self.tbody.attr('id')+' #row'+id).remove();

        self.removeFromList(id);
      });
    }
});
