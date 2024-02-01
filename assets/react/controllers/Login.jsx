import React from "react";
import { useState, useEffect } from "react";
import axios from "axios";

export default function Login() {
  const [password, setPassword] = useState();
  const [email, setEmail] = useState();

  ////------------------------HANDLE SUBMIT-------------------------------////
  const handleSubmit = (e) => {
    e.preventDefault();

    const data = { email: email, password: password };

    ////---------------------REQUETE---------------------////

    axios
      .post("https://localhost:8000/auth", data)
      .then((res) => {
        const { token } = res.data;
        if (token) {
          const tokenStorage = localStorage.setItem("token", token);
          window.location = "/home";
        } else {
          window.location = "/";
        }
      })
      .catch((err) => {
        console.log(err);
      });
  };

  return (
    <>
      <div className="row justify-content-center">
        <div className="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
          <div className="d-flex justify-content-center py-4">
            <a
              href="index.html"
              className="logo d-flex align-items-center w-auto"
            >
              {/* <img src="assets/img/logo.png" alt="" /> */}
              <span className="d-none d-lg-block">NixiaAdmin</span>
            </a>
          </div>

          <div className="card mb-3">
            <div className="card-body">
              <div className="pt-4 pb-2">
                <h5 className="card-title text-center pb-0 fs-4">
                  Login to Your Account
                </h5>
                <p className="text-center small">
                  Enter your username & password to login
                </p>
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
                    />
                    <div className="invalid-feedback">
                      Please enter your email.
                    </div>
                  </div>
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
                    required
                  />
                  <div className="invalid-feedback">
                    Please enter your password!
                  </div>
                </div>

                <div className="col-12">
                  <button
                    className="btn btn-primary w-100 submit-btn"
                    type="submit"
                    onClick={handleSubmit}
                  >
                    Login
                  </button>
                </div>
                <div className="col-12">
                  <p className="small mb-0">
                    <a href="pages-register.html"></a>
                  </p>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </>
  );
}
