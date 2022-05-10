import React, { useState } from "react";
import "./footer.css";

const FooterItem = ({ title, icon, id, onClick, isSelected }) => {
  const selectedStyle = isSelected
    ? {
      color: "#17a2b8",
    }
    : {};
  return (
    <div
      className="footer-item"
      style={{
        transform: `scale(${isSelected ? 1.1 : 1})`,
      }}
      onClick={() => onClick(id)}
    >
      <i class={`${icon} mx-auto d-block nav-img`} style={selectedStyle}></i>
      <p style={selectedStyle}>{title}</p>
    </div>
  );
};

const FooterNavigation = ({ items = [], onChange, selectedItemId }) => {
  return (
    <div className="footer-container" >
      {items.map((item) => {
        return (
          <FooterItem
            title={item.title}
            icon={item.icon}
            id={item.id}
            onClick={onChange}
            isSelected={item.id === selectedItemId}
          />
        );
      })}
    </div>
  );
};

export default FooterNavigation;
