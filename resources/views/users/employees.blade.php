<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Employees table') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table  class=" overflow-x-scroll display dataTables-example" style="width:100%">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Emër</th>
                            <th>Mbiemër</th>
                            <th>Username</th>

                            <th>Total orë pune</th>

                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th></th>
                            <th>Emër</th>
                            <th>Mbiemër</th>
                            <th>Username</th>
                            <th>Total orë pune</th>

                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    $(document).ready(function () {

        // DataTable initialization with expand/collapse feature
        var dataTable = $(".dataTables-example").DataTable({
            processing: false,
            serverSide: true,
            ajax: {
                url: "{{ route('users.employees') }}",
                type: "GET",
            },
            columns: [
                {
                    className: "details-control",
                    orderable: false,
                    data: null,
                    defaultContent: '<i class="fa-solid fa-caret-right"></i>',
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).css({
                            'text-align': 'center', // Center align the content of the control column
                            'cursor': 'pointer' // Add cursor pointer
                        });
                    },
                    title: "", // No title for the control column
                },
                {data: "emri", title: "Emër"},
                {data: "mbiemri", title: "Mbiemër"},
                {data: "username", title: "Username"},
                {
                    data: "total",
                    title: "Total orë pune",
                    render: function (data, type, row) {
                        return parseFloat(data).toFixed(1);
                    },
                },
            ],
            order: [[1, "asc"]],
            responsive: true
        });

        // Handle clicks on the 'details-control' for the main row expansion
        $(".dataTables-example tbody").on("click", "td.details-control", function () {
            var tr = $(this).closest("tr");
            var row = dataTable.row(tr);
            var icon = $(this).find("i");

            if (row.child.isShown()) {
                // Collapse row
                row.child.hide();
                tr.removeClass("shown");
                icon.removeClass("fa-caret-down").addClass("fa-caret-right");
            } else {
                // Expand row
                row.child(format(row.data(), 0)).show();
                tr.addClass("shown");
                icon.removeClass("fa-caret-right").addClass("fa-caret-down");
            }
        });

        // Handle clicks on the 'details-control-year' to expand/collapse year details
        // Inside the click event handler for expanding years to months
        $(".dataTables-example tbody").on(
            "click",
            ".details-control-year",
            function (e) {
                e.stopPropagation(); // Prevent the main row click event from firing
                var year = $(this).data("year");
                var tr = $(this).closest("tr");
                var row = dataTable.row(tr).data();
                var icon = $(this).find("i");
                // Find the next row in the DOM
                var nextTr = tr.next();

                // Check if the next row is already a details row for months
                if (nextTr.hasClass("details-year")) {
                    // If so, toggle its visibility
                    nextTr.remove();
                    icon.removeClass("fa-caret-down").addClass("fa-caret-right");
                } else {
                    // Correctly insert the month details after the current row
                    // Ensure format function returns the details wrapped in a <tr> since we're inserting directly into the table
                    var monthDetailsHtml = format(row[year], 1, year, year); // Make sure this returns a <tr>-wrapped HTML
                    // Use .after() to insert our detailsHtml right after the current row
                    $(monthDetailsHtml).insertAfter(tr).addClass("details-year");
                    icon.removeClass("fa-caret-right").addClass("fa-caret-down");
                }
            }
        );

        // Inside your $(document).ready function...
        // Assuming this is the event handler for clicking on a month detail
        $(".dataTables-example tbody").on(
            "click",
            ".details-control-month",
            function (e) {
                e.stopPropagation();
                var icon = $(this).find("i");
                var month = $(this).data("month");
                var year = $(this).data("year");
                var tr = $(this).closest("tr");
                var rowData = dataTable.row(tr).data();
                var monthData = rowData[year] ? rowData[year][month] : undefined;
                // Assuming rowData[month] is correctly structured as per your console.log example
                if (monthData) {
                    var weekDetailsHtml = format(monthData, 2, "", year, month);
                    var nextTr = tr.next();
                    if (nextTr.hasClass("details-week")) {
                        nextTr.remove();
                        icon.removeClass("fa-caret-down").addClass("fa-caret-right");
                    } else {
                        $(weekDetailsHtml).insertAfter(tr).addClass("details-week");
                        icon.removeClass("fa-caret-right").addClass("fa-caret-down");
                    }
                } else {
                    console.error("Data for the selected month is undefined or null");
                }
            }
        );

        // Inside your $(document).ready function...
        $(".dataTables-example tbody").on(
            "click",
            ".details-control-week",
            function (e) {
                e.stopPropagation();
                var icon = $(this).find("i");
                var week = $(this).data("week");
                var month = $(this).data("month");
                var year = $(this).data("year");
                var tr = $(this).closest("tr");
                var rowData = dataTable.row(tr).data();
                var weekData =
                    rowData[year] && rowData[year][month]
                        ? rowData[year][month][week]
                        : undefined;
                if (weekData) {
                    var dayDetailsHtml = format(weekData, 3, year, month, week);
                    var nextTr = tr.next();
                    if (nextTr.hasClass("details-day")) {
                        nextTr.remove();
                        icon.removeClass("fa-caret-down").addClass("fa-caret-right");
                    } else {
                        $(dayDetailsHtml).insertAfter(tr).addClass("details-day");
                        icon.removeClass("fa-caret-right").addClass("fa-caret-down");
                    }
                } else {
                    console.error("Data for the selected week is undefined or null");
                }
            }
        );

        function format(data, level = 0, key = "", year = "", month = "", week = "") {
            let detailsHtml = "";

            if (!data) {
                console.error("Data is undefined or null.");
                return "<div>Error loading details.</div>";
            }

            // Level 0: Years
            if (level === 0) {
                if (typeof data === "object") {
                    detailsHtml +=
                        '<table cellpadding="5" cellspacing="0" border="0" class="table table-striped table-bordered display" style="padding-left:50px; width: 100%;">' +
                        "<thead style='font-weight: bold; padding: 5px; border: 1px solid rgb(64, 67, 70)'><tr><td></td><td>Vitet</td><td style='padding: 5px; border: 1px solid rgb(64, 67, 70)'>Total orë pune</td></tr></thead><tbody>";
                    Object.keys(data).forEach((year) => {
                        if (data[year] && data[year].total != null) {
                            detailsHtml += `<tr>
                            <td class='details-control-year' data-year="${year}" style="cursor: pointer; text-align: center; padding: 5px; border: 1px solid rgb(64, 67, 70);"><i class="fa fa-caret-right"></i></td>
                            <td style="padding: 5px; border: 1px solid rgb(64, 67, 70); color: darkgray">${year}</td>
                            <td style="padding: 5px; border: 1px solid rgb(64, 67, 70); color: darkgray">${data[year].total.toFixed(1)}</td>
                        </tr>`;
                        }
                    });
                    detailsHtml += "</tbody></table>";
                }
            }
            // Level 1: Months
            else if (level === 1 && typeof data === "object") {
                detailsHtml +=
                    '<tr><td colspan="3"><table cellpadding="5" cellspacing="0" border="0" class=" table table-striped table-bordered display" style="width: 100%; padding: 5px; border: 1px solid rgb(64, 67, 70)">' +
                    "<thead style='font-weight: bold padding: 5px; border: 1px solid rgb(64, 67, 70)'><tr><td></td><td>Muajt</td><td style='padding: 5px; border: 1px solid rgb(64, 67, 70)'>Total orë pune</td></tr></thead><tbody>";

                Object.keys(data).forEach((month) => {
                    let monthData = data[month];
                    if (monthData && monthData.total != null) {
                        detailsHtml += `<tr>
        <td class="details-control-month" data-year="${year}" data-month="${month}" style="cursor: pointer; text-align: center; padding: 5px; border: 1px solid rgb(64, 67, 70)"><i class="fa fa-caret-right"></i></td>
                <td style="padding: 5px; border: 1px solid rgb(64, 67, 70); color: darkgray">${month}</td>
                <td style="padding: 5px; border: 1px solid rgb(64, 67, 70); color: darkgray">${monthData.total.toFixed(1)}</td>
            </tr>`;
                    }
                });
                detailsHtml += "</tbody></table></td></tr>";
            }
            // Level 2: weeks
            else if (level === 2 && typeof data === "object") {
                // At this level, 'data' is expected to be the month data containing weeks.
                // 'data' should directly contain the week entries and metadata like 'total', 'week', 'month'.

                detailsHtml +=
                    '<tr><td colspan="3"><table cellpadding="5" cellspacing="0" border="0" class="table table-striped table-bordered display" style="width: 100%; padding: 5px; border: 1px solid rgb(64, 67, 70)">' +
                    "<thead style='font-weight: bold; padding: 5px; border: 1px solid rgb(64, 67, 70)'><tr><td></td><td>Javët</td><td style='padding: 5px; border: 1px solid rgb(64, 67, 70)'>Total orë pune</td></tr></thead><tbody>";

                // Iterate over keys in the 'data' object, which now represents a single month's data.
                Object.keys(data).forEach((week) => {
                    // Filter out the metadata keys ('total', 'month', 'week') to focus on week-specific data.
                    if (week !== "total" && week !== "month" && week !== "week") {
                        let weekData = data[week]; // Individual week's data
                        // console.log(weekData);
                        // Assuming 'weekData' contains relevant details for the week that you want to display.
                        // You may need to adjust how you're displaying this data based on its structure.

                        // Here's an example assuming you simply want to list out the keys (which represent days)
                        // Adjust this according to what you actually want to display about each week.
                        detailsHtml += `<tr>
                        <td class="details-control-week" data-month="${month}" data-year="${year}" data-week="${week}" style="cursor: pointer; text-align: center; padding: 5px; border: 1px solid rgb(64, 67, 70)"><i class="fa fa-caret-right"></td>
                        <td style="padding: 5px; border: 1px solid rgb(64, 67, 70); color: darkgray">${week}</td> <!-- Displaying the key as the week identifier; adjust as needed -->
                        <td style="padding: 5px; border: 1px solid rgb(64, 67, 70); color: darkgray">${data[week].total.toFixed(1)}</td>
                    </tr>`;
                    }
                });

                detailsHtml += "</tbody></table></td></tr>";
            }
            // Inside your format function, after handling Level 2 (weeks)
            else if (level === 3 && typeof data === "object") {
                // 'data' at this level should represent a single week's data containing days.
                detailsHtml +=
                    '<tr><td colspan="3"><table cellpadding="5" cellspacing="0" border="0" class="table table-striped table-bordered display" style="width: 100%; padding: 5px; border: 1px solid rgb(64, 67, 70)">' +
                    "<thead style='font-weight: bold; padding: 5px; border: 1px solid rgb(64, 67, 70)'><tr><td>Ditët</td><td style='padding: 5px; border: 1px solid rgb(64, 67, 70)'>Total orë pune</td></tr></thead><tbody>";

                // Iterate over the days in the week
                Object.keys(data).forEach((day) => {
                    // Assuming each 'day' in 'data' is an object with at least a 'total' field.
                    let dayData = data[day];
                    if (dayData && dayData.total != null) {
                        detailsHtml += `<tr>
        <td style="padding: 5px; border: 1px solid rgb(64, 67, 70); color: darkgray">${day}</td>
        <td style="padding: 5px; border: 1px solid rgb(64, 67, 70); color: darkgray">${dayData.total.toFixed(1)}</td>
    </tr>`;
                    }
                });

                detailsHtml += "</tbody></table></td></tr>";
            }

            return detailsHtml;
        }
    });

</script>
