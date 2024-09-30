import { useState } from "react";
import "./App.css";

const FormValidationExample = () => {
  const [formData, setFormData] = useState({
    username: "",
    email: "",
    password: "",
    confirmPassword: "",
  });

  const [errors, setErrors] = useState({});

  const validateForm = (data) => {
    const validationErrors = {};
    if (!formData.username.trim()) {
      validationErrors.username = "Username is required";
    }
    if (!formData.email.trim()) {
      validationErrors.email = "Email is required";
    } else if (!/\S+@\S+\.\S+/.test(formData.email)) {
      validationErrors.email = "Email is not valid";
    }
    if (!formData.password.trim()) {
      validationErrors.password = "Password is required";
    } else if (formData.password.length < 6) {
      validationErrors.password = "Password should have at least 6 characters";
    }
    if (formData.password !== formData.confirmPassword) {
      validationErrors.confirmPassword = "Password not matched";
    }
    return validationErrors;
  };

  const handleChange = (event) => {
    const { name, value } = event.target;
    setFormData((prevData) => ({
      ...prevData,
      [name]: value,
    }));
  };

  const handleSubmit = (event) => {
    event.preventDefault();
    const validationErrors = validateForm(formData);
    if (Object.keys(validationErrors).length === 0) {
      alert("Form has been submitted successfully!");
      console.log(formData);
      event.target.reset();
      setFormData({
        username: "",
        email: "",
        password: "",
        confirmPassword: "",
      });
      setErrors({});
    } else {
      setErrors(validationErrors);
    }
  };

  const handleReset = () => {
    setFormData({
      username: "",
      email: "",
      password: "",
      confirmPassword: "",
    });
    setErrors({});
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
          <button type="button" onClick={handleReset} className="enabled">
            Reset
          </button>
          <button type="submit" className="enabled">
            Submit
          </button>
        </div>
      </form>
    </>
  );
};

export default FormValidationExample;
