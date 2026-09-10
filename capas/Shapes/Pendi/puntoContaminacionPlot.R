require(pacman)
pacman::p_load(
  sf,
  shiny,
  plotly,
  dplyr
)
rm(list = ls())

# Cargar datos
pts_extra <- st_read("../capas/Shapes/ptsExtra.geojson") %>%
  filter(Estado == 2)

limite_estatal <- st_read("../capas/Shapes/LimiteEstatal.geojson")
pts_con_estados <- st_join(pts_extra, limite_estatal, join = st_intersects)

# Interfaz
ui <- fluidPage(
  mainPanel(
    plotlyOutput("puntoContaminacionPlot")
  )
)

# Lógica del servidor
server <- function(input, output) {
  output$puntoContaminacionPlot <- renderPlotly({

    # Preprocesamiento
    punto_contaminacion <- pts_con_estados %>%
      st_drop_geometry() %>%
      mutate(
        NOM_ENT = ifelse(is.na(NOM_ENT), "Otro pais", NOM_ENT)
      ) %>%
      group_by(PuntoContaminacion, NOM_ENT) %>%
      summarise(count = n(), .groups = 'drop')

    plot_ly(
      data = punto_contaminacion,
      x = ~PuntoContaminacion,
      y = ~count,
      type = 'bar',
      color = ~NOM_ENT,
      colors = 'Set1',
      text = ~paste0(
        "<b>", count, "</b> registros<br>",
        "Puntos de contaminación: <b>", PuntoContaminacion, "</b><br>",
        "Estado: <b>", NOM_ENT, "</b>"
      ),
      hoverinfo = "text"
    ) %>%
      layout(
        title = "",
        yaxis = list(
          title = "",
          tickmode = "linear",
          dtick = 1
        ),
        barmode = "stack",
        legend = list(
          title = list(text = "<b>Puntos por estado</b>")
        ),
        margin = list(l = 10, r = 10, t = 10, b = 40)
      )
  })
}

# Ejecutar la aplicación
shinyApp(ui = ui, server = server, options = list(port = 4271))
