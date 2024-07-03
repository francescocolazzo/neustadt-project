import React, { useState } from "react";
import { Dropdown, FormControl } from "react-bootstrap";
import "./style.css";

const CustomDropdown = ({ sets, selectedCode, onSelectSet }) => {
  const [isOpen, setIsOpen] = useState(false);
  const [searchTerm, setSearchTerm] = useState("");

  const toggleDropdown = () => {
    setIsOpen(!isOpen);
  };

  const handleSelect = (code) => {
    onSelectSet(code);
    setIsOpen(false);
  };

  const filteredSets = sets.filter((_set) =>
    _set.name.toLowerCase().includes(searchTerm.toLowerCase())
  );

  return (
    <Dropdown
      show={isOpen}
      onToggle={toggleDropdown}
      className="colourful-dropdown border-1 border-dark rounded-dropdown"
    >
      <Dropdown.Toggle variant="white" id="dropdown-basic" className="w-100 ">
        {selectedCode
          ? sets.find((set) => set.code === selectedCode)?.name ||
            "Select a set"
          : "Select a set"}
      </Dropdown.Toggle>

      <Dropdown.Menu className="w-100">
        <div className="p-2">
          <FormControl
            type="text"
            placeholder="Search set..."
            className="mb-2"
            value={searchTerm}
            onChange={(e) => setSearchTerm(e.target.value)}
          />
        </div>
        {filteredSets.length > 0 ? (
          filteredSets.map((_set) => (
            <Dropdown.Item
              key={_set.id}
              onClick={() => handleSelect(_set.code)}
            >
              {_set.name}
            </Dropdown.Item>
          ))
        ) : (
          <Dropdown.Item disabled>No sets found</Dropdown.Item>
        )}
      </Dropdown.Menu>
    </Dropdown>
  );
};

export default CustomDropdown;
