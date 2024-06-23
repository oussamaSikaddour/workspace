import { toggleInertWhenState } from "../traits/Inert";


const IfMenuIsVisible = (filterBtn, filtersContainer) => {
    const expanded = filtersContainer.classList.contains("open");

    filtersContainer.classList.toggle('open', !expanded);


    filterBtn.setAttribute("aria-expanded", !expanded);
    filterBtn.setAttribute("aria-hidden", expanded);

    toggleInertWhenState(filtersContainer,"open",true)

    if (!expanded) {
        const firstFocusableElement = filtersContainer.querySelector('input, select');
        if (firstFocusableElement) {
            firstFocusableElement.focus();
        }
    }
};

const Table = () => {
    const tableContainers = document.querySelectorAll('.table__container');

    if (!tableContainers) {
        return;
    }

    tableContainers.forEach(tc => {
        const tableFiltersBtn = tc.querySelector(".table__filters__btn");
        const tableFiltersContainer = tc.querySelector(".table__filters");

        if (!tableFiltersBtn || !tableFiltersContainer) {
            return;
        }

        tableFiltersBtn.addEventListener('click', () => {
            IfMenuIsVisible(tableFiltersBtn, tableFiltersContainer);
        });

        document.addEventListener('click', (event) => {
            if (!tableFiltersBtn.contains(event.target) && !tableFiltersContainer.contains(event.target)) {
                if (tableFiltersContainer.classList.contains("open")) {
                    IfMenuIsVisible(tableFiltersBtn, tableFiltersContainer);
                }
            }
        });

        toggleInertWhenState(tableFiltersContainer,"open",true)
    });
};

export default Table;
