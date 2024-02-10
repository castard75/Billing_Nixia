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

    const customerId = findCustomer.id;
    console.log(data);

    const obj = {
      referencebr: data.referencebr,
      reference: data.reference,
      state: parseInt(data.state),
      totalht: parseInt(data.totalht),
      totalttc: parseInt(data.totalttc),
      totaltva: parseInt(data.totaltva),
      customerid: `/api/customers/${customerId}`,
      origineid: `/api/myconnectors/${1}`,
    };

    axios
      .post("https://localhost:8000/api/contracts", obj, {
        headers: {
          Authorization: `Bearer ${token}`,
          "Content-Type": "application/ld+json",
        },
      })
      .then((res) => {
        console.log("Réponse du serveur :", res.data);
        window.location.reload();
      })
      .catch((err) => {
        console.error("Erreur lors de la requête :", err);
      });
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
        className="btn btn-primary"
        data-bs-toggle="modal"
        data-bs-target="#basicModal"
      >
        Nouveau Contrat
      </button>
      <div
        className="modal fade"
        id="basicModal"
        tabIndex="-1"
        role="dialog"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true"
      >
        <div className="modal-dialog" role="document">
          <div className="modal-content">
            <div className="modal-header">
              <h5 className="modal-title" id="exampleModalLabel">
                Nouveau Contrat
              </h5>
              <button
                type="button"
                class="btn-close dismiss-btn"
                data-bs-dismiss="modal"
                aria-label="Close"
              ></button>
            </div>
            <div className="modal-body">
              <form>
                <div className="form-group">
                  <label htmlFor="exampleFormControlInput1">Referencebr </label>
                  <input
                    {...register("referencebr", { required: true })}
                    type="text"
                    className="form-control "
                    id="exampleFormControlInput1"
                  />
                  {errors.referencebr && (
                    <span style={{ color: "red" }}>
                      Ce champ est obligatoire
                    </span>
                  )}
                </div>
                <div className="form-group">
                  <label htmlFor="exampleFormControlInput1">Reference </label>
                  <input
                    {...register("reference", { required: true })}
                    type="text"
                    className="form-control "
                    id="exampleFormControlInput1"
                  />
                  {errors.reference && (
                    <span style={{ color: "red" }}>
                      Ce champ est obligatoire
                    </span>
                  )}
                </div>
                <div className="form-group">
                  <label htmlFor="exampleFormControlInput1">State </label>
                  <input
                    max="1"
                    min="0"
                    {...register("state", { required: true })}
                    type="number"
                    className="form-control "
                    id="exampleFormControlInput1"
                  />
                  {errors.state && (
                    <span style={{ color: "red" }}>
                      Ce champ est obligatoire
                    </span>
                  )}
                </div>
                <div className="form-group">
                  <label htmlFor="exampleFormControlInput1">Totalht </label>
                  <input
                    {...register("totalht", { required: true })}
                    type="number"
                    className="form-control "
                    id="exampleFormControlInput1"
                    min="0"
                  />
                  {errors.totalht && (
                    <span style={{ color: "red" }}>
                      Ce champ est obligatoire
                    </span>
                  )}
                </div>
                <div className="form-group">
                  <label htmlFor="exampleFormControlInput1">Totalttc </label>
                  <input
                    {...register("totalttc", { required: true })}
                    type="number"
                    className="form-control "
                    id="exampleFormControlInput1"
                    min="0"
                  />
                  {errors.totalttc && (
                    <span style={{ color: "red" }}>
                      Ce champ est obligatoire
                    </span>
                  )}
                </div>
                <div className="form-group">
                  <label htmlFor="exampleFormControlInput1">Totaltva </label>
                  <input
                    min="0"
                    {...register("totaltva", { required: true })}
                    type="number"
                    className="form-control "
                    id="exampleFormControlInput1"
                  />
                  {errors.totaltva && (
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
