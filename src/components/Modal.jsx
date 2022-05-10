import React from "react";
import { createPortal } from "react-dom";

const Modal = ({ children, onClose }) => {
  return createPortal(
    <div className="popup-box">
      <span className="close-icon" onClick={onClose}>
        x
      </span>
      <div className="box">{children}</div>
    </div>,
    document.getElementById("body")
  );
};

export default Modal;
