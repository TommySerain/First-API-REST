

window.onload = () => {
  const roleAddForm = document.querySelector("#roleAddForm");
  const roleReadOneForm = document.querySelector("#roleReadOneForm");
  const roleUpdateForm = document.querySelector("#roleUpdateForm")
  const roleDeleteForm = document.querySelector("#roleDeleteForm")

  roleAddForm.addEventListener("submit", (e) => {
    e.preventDefault();
    const form = document.forms["roleAddForm"];
    const name_r = form.elements["name_r"].value;
    const id_a = form.elements["id_a"].value;

    const newRole = {
      name_r,
      id_a,
    };

    fetch("http://localhost:8000/role", {
      method: "POST",
      body: JSON.stringify(newRole),
    })
      .then((res) => {
        const errorDiv = document.getElementById("errors");
        const successDiv = document.getElementById("success");
        errorDiv.innerText = "";
        successDiv.innerText = "";

        if (res.status >= 400) {
          errorDiv.innerText = "Une erreur est survenue";
        } else {
          successDiv.innerText = "Le produit a été enregistré";
        }
      })
      .catch((err) => {
        console.error(err);
      });
  });

  roleReadOneForm.addEventListener("submit", async (e) => {
    e.preventDefault();
    const form = document.forms["roleReadOneForm"];
    const id_r = form.elements["id_r"].value;

    let fetchResult = await fetch(`http://localhost:8000/role/${id_r}`, {
      method: "GET",
    })
    let data = await fetchResult.json()
    console.log (data)
    
    let dataArray = Object.values(data)

    const errorDivr = document.getElementById("errorsr");
    const successDivr = document.getElementById("successr");
    errorDivr.innerText = "";
    successDivr.innerText = "";
    if (dataArray[1]!==undefined){
      successDivr.innerText = `${dataArray[1]}`;
    }else{
      errorDivr.innerText = "Role non trouvé"
    }
  });


  roleUpdateForm.addEventListener("submit", (e) => {
    e.preventDefault();
    const form = document.forms["roleUpdateForm"];
    const id_r = form.elements["id_r"].value;
    const name_r = form.elements["name_r"].value;
    const id_a = form.elements["id_a"].value;

    const editedRole = {
      id_r,
      name_r,
      id_a,
    };

    fetch(`http://localhost:8000/role/${id_r}`, {
      method: "PUT",
      body: JSON.stringify(editedRole),
    })
      .then((res) => {
        const errorDive = document.getElementById("errorse");
        const successDive = document.getElementById("successe");
        errorDive.innerText = "";
        successDive.innerText = "";

        if (res.status >= 400) {
          errorDive.innerText = "Une erreur est survenue";
        } else {
          successDive.innerText = "Le produit a été modifié";
        }
      })
      .catch((err) => {
        console.error(err);
      });
  });


  roleDeleteForm.addEventListener("submit", async (e) => {
    e.preventDefault();
    const form = document.forms["roleDeleteForm"];
    const id_r = form.elements["id_r"].value;

    fetch(`http://localhost:8000/role/${id_r}`, {
      method: "DELETE",
    })

    .then((res) => {
      const errorDivd = document.getElementById("errorsd");
      const successDivd = document.getElementById("successd");
      errorDivd.innerText = "";
      successDivd.innerText = "";

      if (res.status >= 400) {
        errorDivd.innerText = "Une erreur est survenue";
      } else {
        successDivd.innerText = "Le produit a été Supprimé";
      }
    })
    .catch((err) => {
      console.error(err);
    });
  });
};
