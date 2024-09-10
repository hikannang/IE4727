import { useState } from "react";
import reactLogo from "./assets/react.svg";
import viteLogo from "/vite.svg";
import "./App.css";

function App() {
  const [formData, setFormData] = useState({
    username: "",
    email: "",
    password: "",
    confirmPassword: "",
  });

  const [errors, setErrors] = useState({});

  const [formStatus, setFormStatus] = useState({
    passwordsMatch: false,
    passwordLength: false,
    isSubmitButtonEnabled: false,
  });

  const validateForm = (updatedData) => {
    const passwordsMatch = updatedData.password === updatedData.confirmPassword;
    const passwordLength = updatedData.password.length >= 6;
    const allFieldsFilled = Object.values(updatedData).every((value) =>
      Boolean(value.trim())
    );

    setErrors((prevErrors) => ({
      ...prevErrors,
      username: updatedData.username ? null : "Name is required",
      email: updatedData.email
        ? !/\S+@\S+\.\S+/.test(updatedData.email)
          ? "Email is not valid"
          : null
        : "Email is required",
      password: updatedData.password
        ? !passwordLength
          ? "Password should have at least 6 characters"
          : null
        : "Password is required",
      confirmPassword: !passwordsMatch ? "Passwords do not match" : "",
    }));

    setFormStatus({
      passwordsMatch,
      passwordLength,
      isSubmitButtonEnabled:
        allFieldsFilled && passwordsMatch && passwordLength,
    });
  };

  const handleChange = (event) => {
    const { name, value } = event.target;
    setFormData((prevData) => {
      const updatedData = {
        ...prevData,
        [name]: value.trimStart(),
      };
      validateForm(updatedData);
      return updatedData;
    });
  };

  const handleSubmit = (event) => {
    event.preventDefault();
    alert("Form has been submitted successfully!");
    console.log(formData);

    setFormData({
      username: "",
      email: "",
      password: "",
      confirmPassword: "",
    });
    setFormStatus({
      passwordsMatch: false,
      passwordLength: false,
      isSubmitButtonEnabled: false,
    });
    event.target.reset();
  };

  const handleReset = () => {
    setFormData({
      username: "",
      email: "",
      password: "",
      confirmPassword: "",
    });
    setErrors({});
    setFormStatus({
      passwordsMatch: false,
      passwordLength: false,
      isSubmitButtonEnabled: false,
    });
  };

  return (
    <>
      <form onSubmit={handleSubmit}>
        <label>Username</label>
        <input
          name="username"
          type="text"
          placeholder="username"
          value={formData.username}
          onChange={handleChange}
          required={true}
        />
        {errors.username && <p>{errors.username}</p>}
        <label>Email</label>
        <input
          name="email"
          type="email"
          placeholder="example@gmail.com"
          value={formData.email}
          onChange={handleChange}
          required={true}
        />
        {errors.email && <p>{errors.email}</p>}
        <label>Password</label>
        <input
          name="password"
          type="password"
          placeholder="Password"
          value={formData.password}
          onChange={handleChange}
          required={true}
        />
        {errors.password && <p>{errors.password}</p>}
        <label>Confirm Password</label>
        <input
          name="confirmPassword"
          type="password"
          placeholder="Confirm Password"
          value={formData.confirmPassword}
          onChange={handleChange}
          required={true}
        />
        {errors.confirmPassword && <p>{errors.confirmPassword}</p>}
        
        <div style={{ display: "flex", justifyContent: "space-between" }}>
          <button type="button" onClick={handleReset} className={`button ${formStatus.isSubmitButtonEnabled ? "" : "disabled"}`}>
            Reset
          </button>
          <button type="submit" disabled={!formStatus.isSubmitButtonEnabled} className={`button ${formStatus.isSubmitButtonEnabled ? "" : "disabled"}`}
          >
            Submit
          </button>
        </div>
      </form>
    </>
  );
}

export default App;
