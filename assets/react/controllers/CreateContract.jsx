import React from "react";
import { useEffect, useState, useMemo } from "react";
import axios from "axios";
import { useForm, SubmitHandler } from "react-hook-form";

export default function CreateContract() {
  const [customers, setCustomers] = useState();

  const [group, setGroup] = useState();
  const [list, setList] = useState([]);

  ////----------------------Validation Fom---------------------////
  const { register, handleSubmit, formState } = useForm({});

  const { errors } = formState;

  const token = localStorage.getItem("token");
  ////---------------------Create task--------------------////

  const makeTask = (data) => {
    const selectedCustomer = data.customers || list[0]?.name;

    const findCustomer = list.find((el) => {
      return el.name == selectedCustomer;
    });

    console.log(findCustomer);

    // const obj = {
    //   title: data.title,
    //   description: data.description,
    //   recurrence: data.recurrence,
    //   technicien: selectedTech,

    // };

    // axios
    //   .post("https://localhost:8000/api/tasks", obj, {
    //     headers: {
    //       "Content-Type": "application/ld+json",
    //     },
    //   })
    //   .then((res) => {
    //     console.log("Réponse du serveur :", res.data);
    //     window.location = "/";
    //   })
    //   .catch((err) => {
    //     console.error("Erreur lors de la requête :", err);
    //   });
  };

  //--------------------------STATE-------------------------//

  useEffect(() => {
    axios
      .request({
        headers: {
          Authorization: `Bearer ${token}`,
        },
        method: "GET",
        url: `https://localhost:8000/api/customers`,
      })
      .then((res) => {
        const customersData = res.data["hydra:member"];

        setList(customersData);
      })
      .catch((err) => console.log(err));
  }, []);

  //Initialisation par défaut des champs du formulaire
  const initDefaultValue = () => {
    setCustomers(list[0]?.name);
  };

  return (
    <>
      <button
        type="button"
        class="btn btn-primary"
        data-bs-toggle="modal"
        data-bs-target="#basicModal"
      >
        Nouveau Contrat
      </button>
      <div
        className="modal fade"
        id="basicModal"
        tabindex="-1"
        tabIndex="-1"
        role="dialog"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true"
      >
        <div className="modal-dialog" role="document">
          <div className="modal-content">
            <div className="modal-header">
              <h5 className="modal-title" id="exampleModalLabel">
                Nouveau ticket
              </h5>
              <button
                type="button"
                className="close btn btn-secondary"
                data-dismiss="modal"
                aria-label="Close"
              >
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div className="modal-body">
              <form>
                <div className="form-group">
                  <label htmlFor="exampleFormControlInput1">TITRE </label>
                  <input
                    {...register("title", { required: true })}
                    type="text"
                    className="form-control scales"
                    id="exampleFormControlInput1"
                  />
                  {errors.title && (
                    <span style={{ color: "red" }}>
                      Ce champ est obligatoire
                    </span>
                  )}
                </div>
                <div className="form-group">
                  <label htmlFor="exampleFormControlSelect1">Client</label>
                  <select
                    className="form-control"
                    id="exampleFormControlSelect1"
                    value={customers}
                    selected={list.length > 0 ? list[0].name : ""}
                    {...register("customers", { required: false })}
                    onChange={(e) => {
                      const selectedValue =
                        e.target.value === undefined
                          ? list[0].name
                          : e.target.value;
                      setCustomers(selectedValue);
                    }}
                  >
                    {list?.map((item) => {
                      return <option key={item.id}> {item.name} </option>;
                    })}
                  </select>
                  {errors.customers && (
                    <span style={{ color: "red" }}>
                      Ce champ est obligatoire
                    </span>
                  )}
                </div>

                <div className="form-group">
                  <label htmlFor="exampleFormControlInput1">TEXTE</label>
                  <textarea
                    type="email"
                    className="form-control"
                    id="exampleFormControlInput1"
                    {...register("description", { required: true })}
                  />
                  {errors.description && (
                    <span style={{ color: "red" }}>
                      Ce champ est obligatoire
                    </span>
                  )}
                </div>
              </form>
            </div>
            <div className="modal-footer">
              <button
                type="button"
                className="btn btn-secondary"
                data-dismiss="modal"
              >
                Annuler
              </button>
              <button
                type="button"
                className="btn btn-primary"
                style={{ background: "#38ad69" }}
                onClick={handleSubmit(makeTask)}
              >
                Créer
              </button>
            </div>
          </div>
        </div>
      </div>
    </>
  );
}
