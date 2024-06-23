import { adjustElementPosition } from "../traits/general";

const showTooltip = (tooltip) => {
tooltip.classList.add("show");
adjustElementPosition(tooltip);
};

const hideTooltip = (tooltip) => {
  tooltip.classList.remove("show");
};

const ToolTip = () => {
  const buttons = document.querySelectorAll('.button:has(.toolTip)');

  buttons.forEach(button => {
    const tooltip = button.querySelector('.toolTip');

    const handleMouseEnter = () => showTooltip(tooltip);
    const handleMouseLeave = () => hideTooltip(tooltip);

    button.addEventListener('mouseenter', handleMouseEnter);
    button.addEventListener('mouseleave', handleMouseLeave);
  });
};

export default ToolTip;
