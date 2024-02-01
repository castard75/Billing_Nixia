import React from "react";
import { useState, useEffect, useRef } from "react";
import axios from "axios";
import { useForm } from "react-hook-form";

export default function Login() {
  const [password, setPassword] = useState();
  const [email, setEmail] = useState();
  const badUseRef = useRef(null);
  /*################################## react-hook-form ###################################*/
  const {
    register,
    handleSubmit,
    formState: { errors },
  } = useForm();

  /*################################## HANDLE SUBMIT ###################################*/

  const submit = (data, e) => {
    e.preventDefault();

    const userInfos = { email: data.email, password: data.password };

    axios
      .post("https://localhost:8000/auth", userInfos)
      .then((res) => {
        const { token } = res.data;
        if (token) {
          const tokenStorage = localStorage.setItem("token", token);
          window.location = "/home";
        } else {
          throw new Error("Token non générer");
        }
      })
      .catch((err) => {
        badUseRef.current.innerText = "Mot de passe ou identifiant incorrect.";
      });
  };

  return (
    <>
      <div className="row justify-content-center">
        <div className="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
          <div className="d-flex justify-content-center py-4">
            <a
              href="index.html"
              className="logo d-flex align-items-center w-auto "
              // style={{ color: "red" }}
            >
              <span className="d-none d-lg-block">Nixia Billing</span>
            </a>
          </div>

          <div className="card mb-3">
            <div className="card-body">
              <div className="pt-4 pb-2">
                <h5 className="card-title text-center pb-0 fs-4">
                  Connexion à votre compte
                </h5>
              </div>

              <form className="row g-3 needs-validation" noValidate>
                <div className="col-12">
                  <label htmlFor="email" className="form-label">
                    Email
                  </label>
                  <div className="input-group has-validation">
                    <span className="input-group-text" id="inputGroupPrepend">
                      @
                    </span>
                    <input
                      type="text"
                      name="email"
                      className="form-control"
                      id="email"
                      required
                      onChange={(e) => setEmail(e.target.value)}
                      {...register("email", { required: true })}
                    />
                  </div>
                  {errors.email && (
                    <p style={{ color: "red" }}>Veuillez saisir votre email.</p>
                  )}
                </div>

                <div className="col-12">
                  <label htmlFor="password" className="form-label">
                    Password
                  </label>
                  <input
                    type="password"
                    name="password"
                    className="form-control"
                    id="password"
                    onChange={(e) => setPassword(e.target.value)}
                    {...register("password", { required: true })}
                  />
                  {errors.password && (
                    <p style={{ color: "red" }}>
                      Veuillez saisir votre mot de passe.
                    </p>
                  )}
                </div>

                <div className="col-12">
                  <button
                    className="btn btn-primary w-100 submit-btn"
                    type="submit"
                    onClick={handleSubmit(submit)}
                  >
                    Se connecter
                  </button>
                </div>
                <div className="col-12">
                  <p className="small mb-0">
                    <a href="pages-register.html"></a>
                  </p>
                </div>
              </form>
              <div id="invalidInfos" className="d-flex justify-content-center">
                {" "}
                <p style={{ color: "red" }} ref={badUseRef}>
                  {" "}
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </>
  );
}
