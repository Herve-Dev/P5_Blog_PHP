export default class Form {
    constructor(dataset, dataForInput) {

        let parentForm = document.querySelector(
          `.span-form${dataset}`
        );

        const formExist = document.getElementById(`form-js${dataset}`)
        if (formExist) {
          formExist.remove()
        }

        let form = document.createElement("form");
        Object.assign(form, {
          action: "#",
          method: "POST",
          enctype: "multipart/form-data",
          id: "form-js" + dataset,
        });

        let label = document.createElement("label");
        label.setAttribute("for", "comment_content");
        label.textContent = "Votre commentaire :";

        let input = document.createElement("input");
        Object.assign(input, {
          type: "text",
          name: "comment_content",
          className: "validate",
          id: "update-input" + dataset,
        });
        input.setAttribute("value", dataForInput);

        let btn = document.createElement("button");
        btn.setAttribute(
          "class",
          `btn waves-effect waves-light btn-update${dataset}`
        );
        btn.setAttribute("type", "button");
        btn.textContent = "Mettre à jour mon commentaire";

        form.append(label, input, btn);
        parentForm.appendChild(form);

        btn.addEventListener("click", function () {
          let newData = document.getElementById(`update-input${dataset}`).value;
          let comment = document.getElementById(`comment-${dataset}`);
          comment.textContent = newData;
           
          const formDelete = document.getElementById(`form-js${dataset}`).remove() 
          var elems = document.querySelector(`.collaps${dataset}`);
          var instances = M.Collapsible.init(elems);
          instances.close(formDelete)

          const newDataFetch = newData.replace(/ /g, "_")

          if (newData.length !== dataForInput.length) {
          
             fetch(`/post/updateCom/${dataset}/${newDataFetch}`, { method: "GET" })
              .then((response => response.json() ))
              .then(response => M.toast({html: response.success, classes: "green"}))
              .catch((err) => {
                  console.log(err);
              });

          } else {
            M.toast({html: "votre message n'a pas été mis à jour", classes: " orange accent-3"})
          } 
        });
    }
}