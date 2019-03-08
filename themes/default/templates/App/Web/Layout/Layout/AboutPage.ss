<div class="content-container unit size3of4 lastUnit">
    <% loop AboutSections %>
        <article>
            <h1>Section $ID</h1>
            <h2>$HeroTitle</h2>
            <h3>$HeroIntroduction.RAW</h3>

            <% if Introduction %>
                <% with Introduction %>
                <hr>
                <div class="introduction clear">
                    <div class="text">
                        <h2>Introduction:</h2>
                        <h3>Alignment: $Alignment</h3>

                        $Content
                    </div>
                    <% if ShowQuote %>
                        <blockquote class="quote">
                            <h2>Quote</h2>
                            $Quote
                            <% if Source %>
                                <cite>– $Source</cite>
                            <% end_if %>
                        </blockquote>
                    <% end_if %>
                </div>
                <% end_with %>
            <% end_if %>

            <% if Blocks %>
                <div class="blocks">
                    <hr>
                    <h2>Blocks</h2>
                    <% loop Blocks %>
                        <div class="block">
                            <h3>Block $ID</h3>
                            <h4>$Title</h4>
                            <% if Introduction %>
                                <p>$Introduction.RAW</p>
                            <% end_if %>
                            <% if Details %>
                                <div class="details">
                                    $Details
                                </div>
                            <% end_if %>
                        </div>
                    <% end_loop %>
                </div>
            <% end_if %>
            <hr>
        </article>
    <% end_loop %>
</div>
