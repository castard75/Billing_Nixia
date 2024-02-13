import React from "react";
import { useEffect, useState, useMemo } from "react";
import axios from "axios";
import { useForm, SubmitHandler } from "react-hook-form";
import Swal from "sweetalert2";
import validator from "validator";

export default function CreateUser() {
  const [message, setMessage] = useState("");
  const [showModal, setShowModal] = useState(false);
  ////################################ STATE UPDATE ################################////

  const [email, setEmail] = useState("");
  const [name, setName] = useState("");
  const [password, setPassword] = useState("");

  ////----------------------Validation Fom---------------------////
  const { register, handleSubmit, formState } = useForm({});

  const { errors } = formState;

  const token = localStorage.getItem("token");

  ////---------------------Create task--------------------////

  const handleUser = (data, e) => {
    e.preventDefault();
    let regex = /^[A-Za-zÀ-ÖØ-öø-ÿ]{3,}(-[A-Za-zÀ-ÖØ-öø-ÿ]+)?$/;
    /* Le mot de passe doit contenir un chiffre de 1 à 9, une lettre minuscule, une lettre majuscule, un caractère spécial, sans espace, et doit être composé de 8 à 16 caractères.*/
    let passwordRegex =
      /^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*\W)(?!.* ).{5,16}$/;

    /*----------------GESTION VALIDATION NAME--------------------*/

    if (!regex.test(data.name)) {
      const targetNameError = document.getElementById("nameError");

      targetNameError.innerHTML = `Veuillez entrez un nom valide svp`;

      setTimeout(() => {
        targetNameError.innerHTML = ``;
      }, 4000);
      return false;
    }
    if (!passwordRegex.test(data.password)) {
      const targetPasswordError = document.getElementById("passwordError");

      targetPasswordError.innerHTML = `Veuillez entrez un mot de passe valide svp`;

      setTimeout(() => {
        targetPasswordError.innerHTML = ``;
      }, 4000);
      return false;
    }

    /*----------------GESTION VALIDATION EMAIL--------------------*/

    if (validator.isEmail(data.email)) {
      Swal.fire({
        title: "Voulez-vous valider l'opération ?",
        showDenyButton: true,
        showCancelButton: false,
        confirmButtonText: "Oui",
        denyButtonText: "Non",
        customClass: {
          actions: "my-actions",
          cancelButton: "order-1 right-gap",
          confirmButton: "order-2",
          denyButton: "order-3",
        },
      }).then((result) => {
        if (result.isConfirmed) {
          Swal.fire({
            position: "center",
            icon: "success",
            title: "Utilisateur crée!",
            showConfirmButton: false,
            timer: 1500,
          });

          const name = data.name;
          const email = data.email;
          const password = data.password;

          console.log(data);
          /*----------------GESTION DATE--------------------*/

          let dates = new Date();
          const iso = dates.toISOString();
          const hours = iso.split("T")[1].split(".")[0];

          const date = iso.split("T")[0];
          const updatedat = date + " " + hours;

          const obj = {
            name: name,
            email: email,
            password: password,
            updatedat: updatedat,
          };

          // setShowModal(false);
          axios
            .post(`https://localhost:8000/api/create/user`, obj, {
              headers: {
                "Content-Type": "application/ld+json",
                Authorization: `Bearer ${token}`,
              },
            })
            .then((response) => {
              // console.log(response.data);
              window.location = "/users";
            })
            .catch((error) => {
              console.error(error);
            });
        } else if (result.isDenied) {
          Swal.fire({
            position: "center",
            icon: "success",
            title: "Changement non éffectuer",
            showConfirmButton: false,
            timer: 1500,
          });
        }
      });
    } else {
      setMessage("Veuillez entrer un email valide svp!");
      setTimeout(() => {
        setMessage("");
      }, 4000);
      return false;
    }
  };

  return (
    <>
      <button
        type="button"
        className="btn btn-primary"
        data-bs-toggle="modal"
        data-bs-target="#basicModal"
      >
        <i className="bi bi-plus-circle"></i>
      </button>
      <div
        className={`modal fade  ${showModal ? "show" : ""}`}
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
                className="btn-close dismiss-btn"
                data-bs-dismiss="modal"
                aria-label="Close"
              ></button>
            </div>
            <div className="modal-body">
              <ul className="list-group list-group-flush">
                <li className="list-group-item">
                  <h6>Nom</h6>
                  <input
                    {...register("name", { required: true })}
                    type="text"
                    className="form-control"
                    id="exampleFormControlInput1"
                    onChange={(e) => {
                      const selectedValue =
                        e.target.value === undefined
                          ? selectedItem?.name
                          : e.target.value;
                      setName(selectedValue);
                    }}
                  />
                  {errors.name && (
                    <span style={{ color: "red" }}>
                      Veuillez entrez un nom valide svp
                    </span>
                  )}
                  <span
                    style={{
                      color: "red",
                      display: errors.name ? "none" : "block",
                    }}
                    id="nameError"
                  ></span>
                </li>
                <li className="list-group-item">
                  <h6>Email</h6>
                  <input
                    {...register("email", {
                      required: true,
                    })}
                    type="email"
                    className="form-control"
                    id="exampleFormControlInput1"
                    onChange={(e) => {
                      const selectedValue =
                        e.target.value === undefined
                          ? selectedItem?.email
                          : e.target.value;
                      setEmail(selectedValue);
                    }}
                  />
                  {errors.email && (
                    <span style={{ color: "red" }}>
                      Veuillez entrer un email valide svp!
                    </span>
                  )}
                  <span
                    style={{
                      color: "red",
                      display: errors.email ? "none" : "block",
                    }}
                    id="test"
                  >
                    {message}
                  </span>
                </li>
                <li className="list-group-item">
                  <h6>Password</h6>
                  <input
                    {...register("password", { required: true })}
                    type="password"
                    className="form-control"
                    id="exampleFormControlInput1"
                    onChange={(e) => {
                      const selectedValue =
                        e.target.value === undefined
                          ? selectedItem?.name
                          : e.target.value;
                      setPassword(selectedValue);
                    }}
                  />
                  {errors.password && (
                    <span style={{ color: "red" }}>
                      Veuillez entrez un mot de passe valide svp
                    </span>
                  )}
                  <span
                    style={{
                      color: "red",
                      display: errors.password ? "none" : "block",
                    }}
                    id="passwordError"
                  ></span>
                </li>
              </ul>
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
                onClick={handleSubmit(handleUser)}
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
